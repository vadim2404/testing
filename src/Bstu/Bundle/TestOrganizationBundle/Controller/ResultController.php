<?php

namespace Bstu\Bundle\TestOrganizationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
    public function unverifiedAction()
    {
        $repo = $this->getDoctrine()
            ->getManager()
            ->getRepository('BstuTestOrganizationBundle:ResultTest')
        ;

        $results = $repo->findUnverfiedTestsByTeacher($this->getUser());

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
        
        return [
            'form' => $this->createForm('bstu_bundle_testorganizationbundle_resulttest', $resultTest)->createView(),
        ];
    }
    
    /**
     * @Route("/verify/{id}/submit", name="teacher_submit_result_verify_test")
     * @Method("POST")
     * @Template("BstuTestOrganizationBundle:Result:verifyTest.html.twig")
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Bstu\Bundle\TestOrganizationBundle\Entity\ResultTest $resultTest
     */
    public function submitVerifyTestAction(Request $request, ResultTest $resultTest)
    {
        $this->checkAccess($resultTest);
        
        $form = $this->createForm('bstu_bundle_testorganizationbundle_resulttest', $resultTest);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($resultTest);
            $em->flush();
            
            $this->redirect($this->generateUrl('teacher_result_unverified'));
        }
        
        return [
            'form' => $form->createView(),
        ];
    }
    
    /**
     * Check access
     * 
     * @param \Bstu\Bundle\TestOrganizationBundle\Entity\ResultTest $resultTest
     * @throws AccessDeniedException
     */
    protected function checkAccess(ResultTest $resultTest)
    {
        if ($resultTest->getTest()->getTeacher() !== $this->getUser()) {
            throw new AccessDeniedException('This test is not created by you');
        }
        
        if ($resultTest->getVerified()) {
            throw new AccessDeniedException('Result is also verified');
        }    
    }
    
    /**
     * @Route("/verified", name="teache_result_verified")
     * @Method({"GET"})
     * @Template()
     */
    public function verifiedAction()
    {
        $repo = $this->getDoctrine()
            ->getManager()
            ->getRepository('BstuTestOrganizationBundle:ResultTest')
        ;

        $results = $repo->findVerfiedTestsByTeacher($this->getUser());

        return [
            'results' => $results,
        ];
    }

}
