<?php

namespace Bstu\Bundle\TestOrganizationBundle\Repository;

use Bstu\Bundle\TestOrganizationBundle\Entity\Test;
use Doctrine\ORM\EntityRepository;

class VariantRepository extends EntityRepository
{
    /**
     * Find variants by test
     * 
     * @param \Bstu\Bundle\TestOrganizationBundle\Entity\Test $test
     * @return array
     */
    public function findByTest(Test $test)
    {
        return $this->createQueryBuilder('v')
            ->where('v.test = :test')
            ->getQuery()
            ->setParameter('test', $test)
            ->execute()
        ;
    }
}
