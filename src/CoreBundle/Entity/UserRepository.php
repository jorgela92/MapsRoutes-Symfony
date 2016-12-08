<?php
namespace CoreBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class UserRepository extends EntityRepository implements UserProviderInterface
{
    public function loadUserByUsername($username)
    {
        $q = $this
            ->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
        ;

        try {
            // The Query::getSingleResult() method throws an exception
            // if there is no record matching the criteria.
            $user = $q->getSingleResult();
        } catch (NoResultException $e) {
            throw new UsernameNotFoundException(sprintf('Unable to find an active admin AcmeUserBundle:User object identified by "%s".', $username), null, 0, $e);
        }

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $this->getEntityName() === $class || is_subclass_of($class, $this->getEntityName());
    }

    public function findById($id)   {
        $sql = $this->createQueryBuilder('u');
        $sql
            ->andWhere('u.id = :id')
            ->setParameter('id', $id);

        $query = $sql->getQuery();

        return $query->getOneOrNullResult();
    }

    public function findByEmail($email)   {
        $sql = $this->createQueryBuilder('u');
        $sql
            ->andWhere('u.email = :email')
            ->setParameter('email', $email);

        $query = $sql->getQuery();

        return $query->getOneOrNullResult();
    }

    //find one user by login
    public function findOneByLogin($email,$password)
    {
        $sql = $this->createQueryBuilder('m');
        $sql
            ->andWhere('m.email = :email')
            ->setParameter('email', $email)
            ->andWhere('m.password = :password')
            ->setParameter('password', $password);

        $query = $sql->getQuery();

        return $query->getOneOrNullResult();
    }
}