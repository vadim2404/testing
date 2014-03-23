<?php

namespace Bstu\Bundle\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Bstu\Bundle\PlanBundle\Entity\Plan;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="student_test_list")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction()
    {
        $plans = $this->getDoctrine()
            ->getManager()
            ->getRepository('BstuPlanBundle:Plan')
            ->findAll()
        ;

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
    }

}
