<?php

namespace AppBundle\Repository;

/**
 * EquipmentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EquipmentRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAllEquipments()
    {
        $qb = $this->createQueryBuilder('e');

        return $qb
            ->getQuery()
            ->getResult();

    }



}
