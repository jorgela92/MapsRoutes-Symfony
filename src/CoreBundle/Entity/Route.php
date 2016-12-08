<?php
namespace CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\VirtualProperty;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;


/**
 * @ORM\Entity(repositoryClass="CoreBundle\Entity\RouteRepository")
 * @ORM\Table(name="routes")
 */
class Route{

    /**
     * @var integer
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var datetime
     * @ORM\Column(type="datetime")
     */
    private $date_creation;

    /**
     * @var ArrayCollection<Waypoint>
     * @ORM\OneToMany(targetEntity="CoreBundle\Entity\Waypoint",mappedBy="route")
     */
    private $waypoints;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\User", inversedBy="routes")
     * @ORM\JoinColumn(name="uer_id", referencedColumnName="id")
     */
    protected $user;


    function __construct()
    {
        $this->date_creation= new \DateTime();
        $this->waypoints=new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return datetime
     */
    public function getDateCreation()
    {
        return $this->date_creation;
    }

    /**
     * @param datetime $date_creation
     */
    public function setDateCreation($date_creation)
    {
        $this->date_creation = $date_creation;
    }

    /**
     * @return ArrayCollection
     */
    public function getWaypoints()
    {
        return $this->waypoints;
    }

    /**
     * @param ArrayCollection $waypoints
     */
    public function setWaypoints($waypoints)
    {
        $this->waypoints = $waypoints;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    public function __toString()    {
        return $this->title;
    }

}
