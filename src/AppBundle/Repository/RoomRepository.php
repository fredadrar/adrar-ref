<?php

namespace AppBundle\Repository;

/**
 * RoomRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RoomRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAllRooms()
    {
        $qb = $this->createQueryBuilder('r');

        return $qb
            ->getQuery()
            ->getResult();

    }

}
