<?php

namespace Bstu\Bundle\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Bstu\Bundle\UserBundle\Entity\Group;

class GroupData implements FixtureInterface
{
    private static $groups = [
        'Студент' => [
            'ROLE_STUDENT',
        ],
        'Преподаватель' => [
            'ROLE_TEACHER',
        ],
        'Оператор' => [
            'ROLE_OPERATOR',
        ],
    ];

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::$groups as $name => $roles) {
            $manager->persist(new Group($name, $roles));
        }

        $manager->flush();
    }

}
