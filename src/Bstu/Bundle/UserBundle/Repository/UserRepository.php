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
            ->select('u.firstName')
            ->join('u.group', 'g')
            ->where('g.name = :group_name')
            ->andWhere('u.firstName LIKE :first_name')
            ->setParameters([
                'group_name' => 'Студент',
                'first_name' => $name . '%',
            ])
            ->getQuery()
        ;
    }
}
