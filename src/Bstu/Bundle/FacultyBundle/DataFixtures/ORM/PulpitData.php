<?php

namespace Bstu\Bundle\FacultyBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Bstu\Bundle\FacultyBundle\Entity\Pulpit;

class PulpitData extends AbstractFixture implements OrderedFixtureInterface
{
    const ORDER = 2;

    private static $pulpits = [
        1 => [
            'Кафедра лесоводства',
            'Кафедра охотоведения',
            'Кафедра лесоустройства',
            'Кафедра лесозащиты и древесиноведения',
            'Кафедра ландшафтного проектирования и садово-паркового строительства',
            'Кафедра лесных культур и почвоведения',
            'Кафедра туризма и природопользования',
        ],
        2 => [
            'Кафедра транспорта леса',
            'Кафедра лесных машин и технологии лесозаготовок',
            'Кафедра технологии деревообрабатывающих производств',
            'Кафедра технологии и дизайна изделий из древесины',
            'Кафедра деревообрабатывающих станков и инструментов',
            'Кафедра энергосбережения, гидравлики и теплотехники',
            'Кафедра материаловедения и технологии металлов',
            'Кафедра деталей машин и подъемно-транспортных устройств',
            'Кафедра инженерной графики',
        ],
        3 => [
            'Кафедра органической химии',
            'Кафедра технологии нефтехимического синтеза и переработки полимерных материалов',
            'Кафедра химической переработки древесины',
            'Кафедра биотехнологии и биоэкологии',
            'Кафедра физико-химических методов сертификации продукции',
            'Кафедра аналитической химии',
            'Кафедра безопасности жизнедеятельности',
            'Кафедра физики',
            'Кафедра иностранных языков',
        ],
        4 => [
            'Кафедра технологии неорганических веществ и общей химической технологии',
            'Кафедра химии, технологии электрохимических производств и материалов электронной техники',
            'Кафедра машин и аппаратов химических и силикатных производств',
            'Кафедра процессов и аппаратов химических производств',
            'Кафедра общей и неорганической химии',
            'Кафедра технологии стекла и керамики',
            'Кафедра химической технологии вяжущих материалов',
            'Кафедра физической и коллоидной химии',
            'Кафедра теоретической механики',
            'Кафедра промышленной экологии',
            'Кафедра автоматизации производственных процессов и электротехники',
            'Кафедра механики материалов и конструкций',
        ],
        5 => [
            'Кафедра экономической теории и маркетинга',
            'Кафедра менеджмента и экономики природопользования',
            'Кафедра экономики и управления на предприятиях ',
            'Кафедра организации производства и экономики недвижимости ',
            'Кафедра статистики, бухгалтерского учета, анализа и аудита',
            'Кафедра высшей математики',
            'Кафедра физического воспитания и спорта',
        ],
        6 => [
            'Кафедра информационных систем и технологий',
            'Кафедра белорусской филологии',
            'Кафедра полиграфических производств',
            'Кафедра редакционно-издательских технологий',
            'Кафедра полиграфического оборудования и систем обработки информации',
        ],
        7 => [
            'Кафедра философии и права',
            'Кафедра истории Беларуси и политологии',
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::$pulpits as $fixtureFacultyId => $pulpits) {
            foreach ($pulpits as $name) {
                $manager->persist((new Pulpit())
                    ->setName($name)
                    ->setFaculty($this->getReference('faculty-' . $fixtureFacultyId))
                );
            }
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return self::ORDER;
    }

}