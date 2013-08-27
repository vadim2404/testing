<?php

namespace Bstu\Bundle\TestingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BstuTestingBundle:Default:index.html.twig', array('name' => $name));
    }
}
