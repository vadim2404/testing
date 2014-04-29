<?php

namespace Bstu\Bundle\UserBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        
        $security = $this->container->get('security.context');
        
        if ($security->getToken() instanceof AnonymousToken) {
            $menu->addChild('Login', [
                'route' => 'fos_user_security_login',
            ]);
            
            $menu->addChild('Register', [
                'route' => 'fos_user_registration_register',
            ]);
            
            $menu->addChild('Restore password', [
                'route' => 'fos_user_resetting_request',
            ]);
            
            return $menu;
        }
        
        if ($security->isGranted('ROLE_TEACHER')) {
            $menu->addChild('Subject', [
                'route' => 'subject',
            ]);
            
            $menu->addChild('Theme', [
                'route' => 'theme',
            ]);
            
            $menu->addChild('Question', [
                'route' => 'question',
            ]);
            
            $menu->addChild('Test', [
                'route' => 'test',
            ]);
            
            $results = $menu->addChild('Result');
            
            $results->addChild('Unverified', [
                'route' => 'teacher_result_unverified',
            ]);
            
            $results->addChild('Verified', [
                'route' => 'teacher_result_verified',
            ]);
        }
        
        if ($security->isGranted('ROLE_OPERATOR')) {
            $menu->addChild('Plan', [
                'route' => 'plan',
            ]);
            
            $menu->addChild('All tests', [
                'route' => 'plan_test',
            ]);
        }
        
        if ($security->isGranted('ROLE_STUDENT')) {
            $menu->addChild('Tests', [
                'route' => 'student_test_list',
            ]);
            
            $menu->addChild('Results', [
                'route' => 'bstu_test_default_result',
            ]);
        }
        
        if ($security->isGranted('ROLE_SUPER_ADMIN')) {
            $menu->addChild('Faculty', [
                'route' => 'faculty',
            ]);
            
            $menu->addChild('Pulpit', [
                'route' => 'pulpit',
            ]);
        }
        
        $menu->addChild('Profile', [
            'route' => 'fos_user_profile_edit',
        ]);
        
        $menu->addChild('Change password', [
            'route' => 'fos_user_change_password',
        ]);
        
        $menu->addChild('Logout', [
            'route' => 'fos_user_security_logout',
        ]);
        
        return $menu;
    }
}
