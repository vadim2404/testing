<?php

namespace Bstu\Bundle\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Bstu\Bundle\PlanBundle\Entity\Plan;
use Bstu\Bundle\TestOrganizationBundle\Entity\ResultTest;
use Bstu\Bundle\TestBundle\Form\ResultTestType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="student_test_list")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $query = $this->getDoctrine()
            ->getManager()
            ->getRepository('BstuPlanBundle:Plan')
            ->findUnfinishedPlans()
        ;

        $paginator  = $this->get('knp_paginator');

        $plans = $paginator->paginate(
            $query,
            $request->query->get('page', 1),
            10
        );

        return [
            'plans' => $plans,
        ];
    }

    /**
     * @Route("/do/{id}", name="student_write_test")
     * @Method({"GET"})
     * @ParamConverter("plan", class="BstuPlanBundle:Plan")
     * @Template()
     */
    public function doAction(Plan $plan)
    {
        $now = new \DateTime('now');
        if ($plan->getStart() > $now) {
            return $this->render('BstuTestBundle:Default:do_countdown.html.twig', [
                'date' => $plan->getStart()->getTimestamp() - $now->getTimestamp(),
            ]);
        }
        if ($plan->isFinished()) {
            throw $this->createNotFoundException('Test has been finished');
        }

        $em = $this->getDoctrine()
            ->getManager()
        ;

        $result = $em->getRepository('BstuTestOrganizationBundle:ResultTest')
            ->findOneByPlan($plan)
        ;

        if (!$result) {
            $result = $this->get('bstu_test.question_shuffle')->shuffle($plan);
        }

        $form = $this->createResultForm($result);

        return [
            'form' => $form->createView(),
            'date' => $plan->getEnd()->getTimestamp() - $now->getTimestamp(),
        ];
    }

    /**
     * @Route("/catch/{id}", name="student_catch_answer", requirements={ "result_test_id" = "\d+" })
     * @Method({"POST"})
     */
    public function catchAnswerAction(Request $request, ResultTest $resultTest)
    {
        if (!$request->isXmlHttpRequest()) {
            throw $this->createNotFoundException('Undefined method');
        }

        if ($resultTest->getPlan()->isFinished()) {
            throw $this->createNotFoundException('Test has been finished');
        }

        $form = $this->createResultForm($resultTest);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()
                ->getManager()
            ;

            $em->persist($resultTest);
            $em->flush();
        }

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * Create result form
     *
     * @param  \Bstu\Bundle\TestOrganizationBundle\Entity\ResultTest $result
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function createResultForm(ResultTest $result)
    {
        return $this->createForm(new ResultTestType(), $result, [
            'action' => $this->generateUrl('student_catch_answer', ['id' => $result->getId()]),
            'method' => 'POST',
        ]);
    }

    /**
     * @Route("/result")
     * @Method("GET")
     * @Template()
     */
    public function resultAction(Request $request)
    {
        $query = $this->getDoctrine()
            ->getManager()
            ->getRepository('BstuTestOrganizationBundle:ResultTest')
            ->findVerifiedTestsByStudent($this->getUser())
        ;

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
}
