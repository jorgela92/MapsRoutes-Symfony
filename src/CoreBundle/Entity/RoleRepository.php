<?php
/**
 * Created by PhpStorm.
 * User: juanjoselabella
 * Date: 5/11/15
 * Time: 11:25
 */

namespace CoreBundle\Entity;


use Doctrine\ORM\EntityRepository;

class RoleRepository extends EntityRepository
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

//find full list
    public function findAll()
    {
        $sql = $this->createQueryBuilder('c');

        $query = $sql->getQuery();
        return $query->getResult();
    }
}//class