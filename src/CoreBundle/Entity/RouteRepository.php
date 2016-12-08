<?php
namespace CoreBundle\Entity;

use Doctrine\ORM\EntityRepository;

class RouteRepository extends EntityRepository{


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

    //find full list
    public function findAll()
    {
        $sql = $this->createQueryBuilder('c');

        $query = $sql->getQuery();
        return $query->getResult();
    }

    //find full list by user id
    public function findListByUserId($userId)
    {
        $sql = $this->createQueryBuilder('c');

        $sql
            ->andWhere('c.user = :id')
            ->setParameter('id', $userId);

        $query = $sql->getQuery();
        return $query->getResult();
    }
}//class