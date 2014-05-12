<?php

namespace Bstu\Bundle\TestOrganizationBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Bstu\Bundle\UserBundle\Entity\User;

class ResultTestRepository extends EntityRepository
{
    /**
     * Find tests by teacher
     *
     * @param  \Bstu\Bundle\UserBundle\Entity\User $user
     * @param  boo                                 $verified
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function findTestsByTeacher(User $user, $verified = false)
    {
        return $this->createQueryBuilder('rt')
            ->join('rt.test', 't')
            ->join('rt.plan', 'p')
            ->where('t.teacher = :teacher')
            ->andWhere('rt.verified = :verified')
            ->andWhere('p.end < :now')
            ->orderBy('rt.id', 'desc')
            ->setParameters([
                'teacher' => $user,
                'verified' => $verified,
                'now' => new \DateTime('now'),
            ])
        ;
    }

    /**
     * Find unverified tests
     *
     * @param  \Bstu\Bundle\UserBundle\Entity\User $user
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findUnverfiedTestsByTeacher(User $user)
    {
        return $this->findTestsByTeacher($user)
            ->andWhere('t.automatic = :automatic')
            ->setParameter('automatic', false)
        ;
    }

    /**
     * Find verified tests
     *
     * @param  \Bstu\Bundle\UserBundle\Entity\User $user
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findVerifiedTestsByTeacher(User $user)
    {
        return $this->findTestsByTeacher($user, true);
    }

    /**
     * Find verified tests by student
     *
     * @param  \Bstu\Bundle\UserBundle\Entity\User $user
     * @return \Doctrine\ORM\Query
     */
    public function findVerifiedTestsByStudent(User $user)
    {
        return $this->createQueryBuilder('rt')
            ->where('rt.verified = :verified')
            ->andWhere('rt.student = :student')
            ->orderBy('rt.id', 'desc')
            ->getQuery()
            ->setParameters([
                'verified' => true,
                'student' => $user,
            ])
        ;
    }

    /**
     * Find unverified results from automatic test
     *
     * @return \Doctrine\ORM\Query
     */
    public function findUnverifiedAutomaticTest()
    {
        return $this->createQueryBuilder('rt')
            ->join('rt.test', 't')
            ->join('rt.plan', 'p')
            ->where('t.automatic = :automatic')
            ->andWhere('p.end < :now')
            ->andWhere('rt.verified = :verified')
            ->setParameters([
                'automatic' => true,
                'now' => new \DateTime('now'),
                'verified' => false,
            ])
        ;
    }
}
