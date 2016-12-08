<?php
namespace CoreBundle\Model;

use CoreBundle\Entity\Route;
use Doctrine\ORM\EntityManagerInterface;


class RouteModel {

    /** @var  \CoreBundle\Entity\RouteRepository */
    private $repository;

    /** @var  EntityManagerInterface */
    private $entityManager;

    function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository("CoreBundle:Route");
        $this->entityManager = $entityManager;
    }

    public function add(Route $new){
        $this->entityManager->persist($new);
    }

    public function update(Route $new){
        $this->entityManager->persist($new);
    }

    public function findById($id){
        return $this->repository->findById($id);
    }

    public function findAll(){
        return $this->repository->findAll();
    }

    public function findListByUserId($userId){
        return $this->repository->findListByUserId($userId);
    }
    public function applyChanges(){
        $this->entityManager->flush();
    }

}
