<?php

namespace Bstu\Bundle\TestOrganizationBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ThemeRepository extends EntityRepository
{
    /**
     * Find all themes through subjects that relates to teacher
     *
     * @param \Bstu\Bundle\UserBundle\Entity\User $teacher
     * @return \Doctrine\ORM\Query
     */
    public function findAllByTeacher($teacher)
    {
        return $this->createQueryBuilder('t')
            ->innerJoin('t.subject', 's')
            ->where('s.teacher = ?1')
            ->setParameter(1, $teacher)
            ->getQuery()
        ;
    }
}
