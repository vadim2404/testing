<?php

namespace Bstu\Bundle\TestOrganizationBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Bstu\Bundle\UserBundle\Entity\User;

class QuestionRepository extends EntityRepository
{
    /**
     * Find questions by teacher
     *
     * @param  \Bstu\Bundle\UserBundle\Entity\User $teacher
     * @return \Doctrine\ORM\Query
     */
    public function findByTeacher(User $teacher)
    {
        return $this->createQueryBuilder('q')
            ->join('q.theme', 't')
            ->join('t.subject', 's')
            ->where('q.teacher = :teacher')
            ->getQuery()
            ->setParameter('teacher', $teacher)
        ;
    }
}
