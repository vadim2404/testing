<?php

namespace Bstu\Bundle\FacultyBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Bstu\Bundle\FacultyBundle\Entity\Faculty;

class FacultyData extends AbstractFixture implements OrderedFixtureInterface
{
    const ORDER = 1;

    /**
     * Name of faculties
     *
     * @var staticvar $faculties
     */
    private static $faculties = [
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
            $this->addReference('faculty-' . $fixtureId, $faculty);
        }
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return self::ORDER;
    }
}
