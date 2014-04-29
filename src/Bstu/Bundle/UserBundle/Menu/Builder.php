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
            $menu->addChild('Войти', [
                'route' => 'fos_user_security_login',
            ]);
            
            $menu->addChild('Зарегистрироваться', [
                'route' => 'fos_user_registration_register',
            ]);
            
            $menu->addChild('Восстановить пароль', [
                'route' => 'fos_user_resetting_request',
            ]);
            
            return $menu;
        }
        
        if ($security->isGranted('ROLE_TEACHER')) {
            $menu->addChild('Предметы', [
                'route' => 'subject',
            ]);
            
            $menu->addChild('Темы', [
                'route' => 'theme',
            ]);
            
            $menu->addChild('Вопросы', [
                'route' => 'question',
            ]);
            
            $menu->addChild('Тесты', [
                'route' => 'test',
            ]);
            
            $results = $menu->addChild('Результаты');
            
            $results->addChild('Непроверенные', [
                'route' => 'teacher_result_unverified',
            ]);
            
            $results->addChild('Проверенные', [
                'route' => 'teacher_result_verified',
            ]);
        }
        
        if ($security->isGranted('ROLE_OPERATOR')) {
            $menu->addChild('Планы', [
                'route' => 'plan',
            ]);
            
            $menu->addChild('Все тесты', [
                'route' => 'plan_test',
            ]);
        }
        
        if ($security->isGranted('ROLE_STUDENT')) {
            $menu->addChild('Тесты', [
                'route' => 'student_test_list',
            ]);
            
            $menu->addChild('Результаты', [
                'route' => 'bstu_test_default_result',
            ]);
        }
        
        if ($security->isGranted('ROLE_SUPER_ADMIN')) {
            $menu->addChild('Факультеты', [
                'route' => 'faculty',
            ]);
            
            $menu->addChild('Кафедры', [
                'route' => 'pulpit',
            ]);
            
            $menu->addChild('Пользователи', [
                'route' => 'user',
            ]);
        }
        
        $menu->addChild('Профиль', [
            'route' => 'fos_user_profile_edit',
        ]);
        
        $menu->addChild('Изменить пароль', [
            'route' => 'fos_user_change_password',
        ]);
        
        $menu->addChild('Выйти', [
            'route' => 'fos_user_security_logout',
        ]);
        
        return $menu;
    }
}
