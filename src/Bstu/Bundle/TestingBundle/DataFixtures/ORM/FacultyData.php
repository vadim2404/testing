<?php

namespace Bstu\Bundle\TestingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Bstu\Bundle\TestingBundle\Entity\Faculty;

class FacultyData extends AbstractFixture implements OrderedFixtureInterface
{
    const ORDER = 1;

    /**
     * Name of faculties
     *
     * @var staticvar $faculties
     */
    static $faculties = [
        1 => 'Лесохозяйственный факультет',
        2 => 'Факультет технологии и техники лесной промышленности	',
        3 => 'Факультет технологии органических веществ',
        4 => 'Факультет химической технологии и техники',
        5 => 'Инженерно-экономический факультет',
        6 => 'Факультет издательского дела и полиграфии',
        7 => 'Общеуниверситетские кафедры',
    ];

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::$faculties as $fixtureId => $name) {
            $faculty = (new Faculty())->setName($name);

            $manager->persist($faculty);
            $manager->flush();

            $this->addReference('faculty-' . $fixtureId, $faculty);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return self::ORDER;
    }
}
