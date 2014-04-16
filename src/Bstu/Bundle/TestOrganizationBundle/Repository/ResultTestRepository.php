<?php

namespace Bstu\Bundle\TestOrganizationBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Bstu\Bundle\UserBundle\Entity\User;

class ResultTestRepository extends EntityRepository
{
    /**
     * Find tests by teacher
     * 
     * @param \Bstu\Bundle\UserBundle\Entity\User $user
     * @param boo $verified
     * @return array
     */
    protected function findTestsByTeacher(User $user, $verified = false)
    {
        return $this->createQueryBuilder('rt')
            ->join('rt.test', 't')
            ->join('rt.plan', 'p')
            ->where('t.teacher = :teacher')
            ->andWhere('rt.verified = :verified')
            ->andWhere('p.end > :now')
            ->getQuery()
            ->setParameters([
                'teacher' => $user,
                'verified' => $verified,
                'now' => new \DateTime('now'),
            ])
            ->execute()
        ;
    }

    /**
     * Find unverified tests
     *
     * @param \Bstu\Bundle\UserBundle\Entity\User $user
     * @return array
     */
    public function findUnverfiedTestsByTeacher(User $user)
    {
        return $this->findTestsByTeacher($user);
    }

    /**
     * Find verified tests
     *
     * @param \Bstu\Bundle\UserBundle\Entity\User $user
     * @return type
     */
    public function findVerifiedTestsByTeacher(User $user)
    {
        return $this->findTestsByTeacher($user, true);
    }
}
