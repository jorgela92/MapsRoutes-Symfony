<?php
namespace CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\VirtualProperty;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="CoreBundle\Entity\UserRepository")
 * @ORM\Table(name="users"),
 */

class User implements UserInterface {


    /**
     * @var string $id
     * @ORM\Column(name="id", type="string")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Kiefernwald\DoctrineUuid\Doctrine\ORM\UuidGenerator")
     */
    protected $id;


    /**
     * @var datetime
     * @ORM\Column(type="datetime")
     */
    private $date_creation;


    /**
     * @ORM\Column(name="username", type="string", length=255)
     */
    protected $username;

    /**
     * @ORM\Column(name="password", type="string", length=255)
     */
    protected $password;

    /**
     * @ORM\Column(name="salt", type="string", length=255)
     */
    protected $salt;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\Column(name="email", type="string", length=255)
     */
    protected $email;

    /**
     * @var ArrayCollection<Route>
     * @ORM\OneToMany(targetEntity="CoreBundle\Entity\Route",mappedBy="user")
     */
    private $routes;


    /**
     * @var Role
     * @ORM\OneToOne(targetEntity="CoreBundle\Entity\Role",mappedBy="user")
     */
    protected $roles;


    function __construct()
    {
        $this->date_creation= new \DateTime();
        $this->routes=new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @param ArrayCollection $routes
     */
    public function setRoutes($routes)
    {
        $this->routes = $routes;
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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param mixed $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getRoles()
    {
        return array(
            $this->roles->getName()
        );
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }


    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}
