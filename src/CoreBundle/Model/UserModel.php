<?php

namespace CoreBundle\Model;

use Doctrine\ORM\EntityManagerInterface;
use CoreBundle\Entity\User;

class UserModel {

    /** @var  \CoreBundle\Entity\UserRepository */
    private $repository;

    /** @var  EntityManagerInterface */
    private $entityManager;

    function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository("CoreBundle:User");
        $this->entityManager = $entityManager;
    }

    public function findUserById($id){
        return $this->repository->findById($id);
    }

    public function findUserByEmail($email){
        return $this->repository->findByEmail($email);
    }

    //find user by login
    public function findUserByLogin($email,$password)
    {
        return $this->repository->findOneByLogin($email,$password);
    }

    //find all
    public function findAll()
    {
        return $this->repository->findAll();
    }
}