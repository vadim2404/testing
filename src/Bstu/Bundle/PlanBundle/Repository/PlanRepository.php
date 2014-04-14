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
    public function findUnfinishedPlans()
    {
        $maxInterval = new \DateInterval('PT90M');
        $minInterval = new \DateInterval('PT90M');
        $minInterval->invert = 1;
        $curDate = new \DateTime('now');
        $minDate = clone $curDate;
        $maxDate = clone $curDate;
        $maxDate->add($maxInterval);
        $minDate->add($minInterval);

        $plans = $this->createQueryBuilder('plan')
            ->where('plan.start <= :max')
            ->andWhere('plan.start > :min')
            ->setParameter('max', $maxDate)
            ->setParameter('min', $minDate)
            ->getQuery()
            ->execute()
        ;

        $result = [];
        foreach ($plans as $plan) {
            if (!$plan->isFinished()) {
                $result[] = $plan;
            }
        }

        return $result;
    }
}
