<?php

namespace Bstu\Bundle\TestOrganizationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Bstu\Bundle\TestOrganizationBundle\Entity\ResultTest;

/**
 * @Route("/result")
 */
class ResultController extends Controller
{
    /**
     * @Route("/", name="teacher_result_unverified")
     * @Method({"GET"})
     * @Template()
     */
    public function unverifiedAction(Request $request)
    {
        $repo = $this->getDoctrine()
            ->getManager()
            ->getRepository('BstuTestOrganizationBundle:ResultTest')
        ;

        $query = $repo->findUnverfiedTestsByTeacher($this->getUser());
        $paginator  = $this->get('knp_paginator');

        $results = $paginator->paginate(
            $query,
            $request->query->get('page', 1),
            10
        );

        return [
            'results' => $results,
        ];
    }

    /**
     * @Route("/verify/{id}", name="teacher_result_verify_test")
     * @Method("GET")
     * @Template()
     */
    public function verifyTestAction(ResultTest $resultTest)
    {
        $this->checkAccess($resultTest);

        if ($resultTest->getVerified()) {
            throw new AccessDeniedException('Result is also verified');
        }

        if ($resultTest->getTest()->getAutomatic()) {
            throw new AccessDeniedException('Result will be calculated automaticly');
        }

        return [
            'form' => $this->createForm('bstu_bundle_testorganizationbundle_resulttest', $resultTest)->createView(),
        ];
    }

    /**
     * @Route("/verify/{id}/submit", name="teacher_submit_result_verify_test")
     * @Method("POST")
     * @Template("BstuTestOrganizationBundle:Result:verifyTest.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request             $request
     * @param \Bstu\Bundle\TestOrganizationBundle\Entity\ResultTest $resultTest
     */
    public function submitVerifyTestAction(Request $request, ResultTest $resultTest)
    {
        $this->checkAccess($resultTest);

        if ($resultTest->getVerified()) {
            throw new AccessDeniedException('Result is also verified');
        }

        if ($resultTest->getTest()->getAutomatic()) {
            throw new AccessDeniedException('Result will be calculated automaticly');
        }

        $form = $this->createForm('bstu_bundle_testorganizationbundle_resulttest', $resultTest);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($resultTest);
            $em->flush();

            return $this->redirect($this->generateUrl('teacher_result_unverified'));
        }

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * Check access
     *
     * @param  \Bstu\Bundle\TestOrganizationBundle\Entity\ResultTest $resultTest
     * @throws AccessDeniedException
     */
    protected function checkAccess(ResultTest $resultTest)
    {
        if ($resultTest->getTest()->getTeacher() !== $this->getUser()) {
            throw new AccessDeniedException('This test is not created by you');
        }
    }

    /**
     * @Route("/verified", name="teacher_result_verified")
     * @Method({"GET"})
     * @Template()
     */
    public function verifiedAction(Request $request)
    {
        $repo = $this->getDoctrine()
            ->getManager()
            ->getRepository('BstuTestOrganizationBundle:ResultTest')
        ;

        $form = $this->createForm('bstu_bundle_testorganizationbundle_filter');
        $form->handleRequest($request);

        $query = $repo->findVerifiedTestsByTeacher($this->getUser());

        if ($form->isValid()) {
            $data = $form->getData();

            if (!empty($data['test'])) {
                $query->andWhere('rt.test = :test')
                    ->setParameter('test', $data['test'])
                ;
            }

            if (!empty($data['student'])) {
                $query->join('rt.student', 's')
                    ->andWhere('s.lastName = :student')
                    ->setParameter('student', $data['student'])
                ;
            }

            if (!empty($data['period'])) {
                $date = explode('/', $data['period']);
                $query->andWhere('p.start >= :started')
                    ->andWhere('p.start <= :ended')
                    ->setParameter('started', \DateTime::createFromFormat('Y-m-d H:i:s', $date[0]))
                    ->setParameter('ended', \DateTime::createFromFormat('Y-m-d H:i:s', $date[1]))
                ;
            }
        }

        $paginator  = $this->get('knp_paginator');

        $results = $paginator->paginate(
            $query,
            $request->query->get('page', 1),
            10
        );

        return [
            'results' => $results,
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/unverify/{id}", name="teacher_result_unverify_test")
     * @Method("GET")
     * @Template()
     *
     * @param \Bstu\Bundle\TestOrganizationBundle\Entity\ResultTest $resultTest
     */
    public function markAsUnverifiedAction(Request $request, ResultTest $resultTest)
    {
        $this->checkAccess($resultTest);

        if ($resultTest->getVerified()) {
            $resultTest->setVerified(false);

            $em = $this->getDoctrine()->getManager();
            $em->persist($resultTest);
            $em->flush();
        }

        if ($resultTest->getTest()->getAutomatic()) {
            return $this->redirect($request->headers->get('referer'));
        }

        return $this->redirect($this->generateUrl('teacher_result_verify_test', [
            'id' => $resultTest->getId(),
        ]));
    }

    /**
     * @Route("/students", name="user_students")
     * @Method("GET")
     */
    public function studentAction(Request $request)
    {
        $name = $request->query->get('term');

        $users = $this->getDoctrine()
            ->getManager()
            ->getRepository('BstuUserBundle:User')
            ->findStudentsWithNameFiltering($name)
            ->execute()
        ;

        return new JsonResponse(array_column($users, 'lastName'));
    }
}
