<?php

namespace Bstu\Bundle\TestOrganizationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
