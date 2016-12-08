<?php
namespace CoreBundle\Model;

use CoreBundle\Entity\Role;
use CoreBundle\Entity\typeGender;
use Doctrine\ORM\EntityManagerInterface;

class RoleModel {

    /** @var  \CoreBundle\Entity\RoleRepository */
    private $repository;

    /** @var  EntityManagerInterface */
    private $entityManager;

    function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository("CoreBundle:Role");
        $this->entityManager = $entityManager;
    }

    public function findById($id){
        return $this->repository->findById($id);
    }

    //find all
    public function findAll()
    {
        return $this->repository->findAll();
    }
}