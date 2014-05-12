<?php

namespace Bstu\Bundle\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * Find students filtered by name
     *
     * @return \Doctrine\ORM\Query
     */
    public function findStudentsWithNameFiltering($name)
    {
        return $this->createQueryBuilder('u')
            ->select('u.lastName')
            ->join('u.group', 'g')
            ->where('g.name = :group_name')
            ->andWhere('u.lastName LIKE :last_name')
            ->setParameters([
                'group_name' => 'Студент',
                'last_name' => $name . '%',
            ])
            ->getQuery()
        ;
    }
}
