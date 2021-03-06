<?php

namespace Bstu\Bundle\PlanBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PlanRepository extends EntityRepository
{
    /**
     * Find plans that not finished now
     *
     * @return \Doctrine\ORM\Query
     */
    public function findUnfinishedPlans()
    {
        return $this->createQueryBuilder('p')
            ->where('p.end >= :now')
            ->getQuery()
            ->setParameter('now', new \DateTime('now'))
        ;
    }
}
