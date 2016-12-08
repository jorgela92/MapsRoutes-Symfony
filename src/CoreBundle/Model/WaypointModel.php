<?php
namespace CoreBundle\Model;


use CoreBundle\Entity\Waypoint;
use CoreBundle\Entity\WaypointRepository;
use Doctrine\ORM\EntityManagerInterface;


class WaypointModel {

    /** @var  WaypointRepository */
    private $repository;

    /** @var  EntityManagerInterface */
    private $entityManager;

    function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository("CoreBundle:Waypoint");
        $this->entityManager = $entityManager;
    }

    public function findById($id){
        return $this->repository->findById($id);
    }

    public function findByRouteId($idRoute){
        return $this->repository->findByRouteId($idRoute);
    }

    public function findAll(){
        return $this->repository->findAll();
    }

    public function add(Waypoint $new){
        $this->entityManager->persist($new);
    }

    public function applyChanges(){
        $this->entityManager->flush();
    }
}