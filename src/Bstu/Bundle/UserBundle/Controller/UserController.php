<?php

namespace Bstu\Bundle\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bstu\Bundle\UserBundle\Entity\User;

/**
 * @Route("/admin/user")
 * @Method("GET")
 * @Template()
 */
class UserController extends Controller
{
    const DEFAULT_PASSWORD = '1234';
    
    /**
     * @Route("/", name="user")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository('BstuUserBundle:User')->createQueryBuilder('u');
        $paginator  = $this->get('knp_paginator');
        
        $entities = $paginator->paginate(
            $query,
            $request->query->get('page', 1),
            10
        );

        return [
            'entities' => $entities,
        ];
        
    }
    
    /**
     * @Route("/{id}", name="user_reset")
     * @Method("GET")
     */
    public function resetAction(Request $request, User $user)
    {
        $user->setPlainPassword(self::DEFAULT_PASSWORD);
        
        $this->get('fos_user.user_manager')->updateUser($user);
        
        $request->getSession()->getFlashBag()->add('notice', 'User password updated to ' . self::DEFAULT_PASSWORD);
        
        return $this->redirect($this->generateUrl('user'));
    }
}
