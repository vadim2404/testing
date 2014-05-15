<?php

namespace Bstu\Bundle\TestOrganizationBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Bstu\Bundle\UserBundle\Entity\User;

class TestRepository extends EntityRepository
{
    /**
     * Find tests by teacher
     *
     * @param  \Bstu\Bundle\UserBundle\Entity\User $teacher
     * @return \Doctrine\ORM\Query
     */
    public function findByTeacher(User $teacher)
    {
        return $this->createQueryBuilder('t')
            ->join('t.subject', 's')
            ->where('t.teacher = :teacher')
            ->getQuery()
            ->setParameter('teacher', $teacher)
        ;
    }
}
