<?php
namespace CoreBundle\Entity;

use Doctrine\ORM\EntityRepository;

class WaypointRepository extends EntityRepository
{

    //find one by id
    public function findById($id)
    {
        $sql = $this->createQueryBuilder('c');
        $sql
            ->andWhere('c.id = :id')
            ->setParameter('id', $id);

        $query = $sql->getQuery();
        return $query->getOneOrNullResult();
    }

    //find one by route id
    public function findByRouteId($idRoute)
    {
        $sql = $this->createQueryBuilder('c');
        $sql
            ->andWhere('c.route = :id')
            ->setParameter('id', $idRoute);

        $query = $sql->getQuery();
        return $query->getResult();
    }

    //find full list
    public function findAll()
    {
        $sql = $this->createQueryBuilder('c');

        $query = $sql->getQuery();
        return $query->getResult();
    }



}//class