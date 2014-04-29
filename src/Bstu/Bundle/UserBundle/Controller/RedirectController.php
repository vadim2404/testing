<?php

namespace Bstu\Bundle\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class RedirectController extends Controller
{
    /**
     * @Route("/", name="_welcome")
     * @Method("GET")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function indexAction()
    {
        $user = $this->getUser();
        $security = $this->container->get('security.context');
        
        if (!$user) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
        
        if ($security->isGranted('ROLE_TEACHER')) {
            return $this->redirect($this->generateUrl('subject'));
        }
        
        if ($security->isGranted('ROLE_OPERATOR')) {
            return $this->redirect($this->generateUrl('plan'));
        }
        
        if ($security->isGranted('ROLE_STUDENT')) {
            return $this->redirect($this->generateUrl('student_test_list'));
        }
        
        if ($security->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->redirect($this->generateUrl('faculty'));
        }
        
        throw new AccessDeniedException();
    }
    
}
