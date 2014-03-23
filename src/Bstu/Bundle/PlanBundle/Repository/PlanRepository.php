<?php

namespace Bstu\Bundle\PlanBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PlanRepository extends EntityRepository
{
    /**
     * Find plans that not started now
     * 
     * @return array
     */
    public function findUnstartedPlans()
    {
        return $this->createQueryBuilder('plan')
            ->where('plan.start < :now')
            ->setParameter('now', new \DateTime('now'))
            ->getQuery()
            ->execute()
        ;
    }
}
