<?php

namespace CoreBundle;

use CoreBundle\Entity\User;
use CoreBundle\Entity\Role;
use CoreBundle\Entity\Route;
use CoreBundle\Entity\Waypoint;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 22/11/16
 * Time: 19:56
 */
class AdminFixtureLoader implements FixtureInterface, ContainerAwareInterface
{

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        // USER
        $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
        $user = new User();
        $user->setUsername('admin');
        $user->setName('admin');
        $user->setEmail('admin@mapsroute.com');
        $user->setSalt(md5(time()));
        $password = $encoder->encodePassword(
            '1212', $user->getSalt());
        $user->setPassword($password);
        $manager->persist($user);
        // ROLE
        $roleSA = new Role();
        $roleSA->setName('ROLE_ADMIN');
        $roleSA->setUser($user);
        $manager->persist($roleSA);
        // ROUTES
        $route0 = new Route();
        $route0->setTitle("PRIMERA RUTA");
        $route0->setDescription("PRIMER EJEMPLO DE RUTA");
        $route0->setUser($user);
        $manager->persist($route0);

        $route1 = new Route();
        $route1->setTitle("SEGUNDA RUTA");
        $route1->setDescription("SEGUNDO EJEMPLO DE RUTA");
        $route1->setUser($user);
        $manager->persist($route1);

        // WAYPOINT
        $waypoint0 = new Waypoint();
        $waypoint0->setTitle("00/00/0000 00:00");
        $waypoint0->setDescription("PUNTO DE PRUEBA");
        $waypoint0->setLatitude("0.0");
        $waypoint0->setLongitude("0.0");
        $waypoint0->setRoute($route0);
        $manager->persist($waypoint0);

        $waypoint1 = new Waypoint();
        $waypoint1->setTitle("11/11/1111 11:11");
        $waypoint1->setDescription("PUNTO DE PRUEBA");
        $waypoint1->setLatitude("1.1");
        $waypoint1->setLongitude("1.1");
        $waypoint1->setRoute($route0);
        $manager->persist($waypoint1);

        $waypoint2 = new Waypoint();
        $waypoint2->setTitle("22/22/2222 22:22");
        $waypoint2->setDescription("PUNTO DE PRUEBA");
        $waypoint2->setLatitude("2.2");
        $waypoint2->setLongitude("2.2");
        $waypoint2->setRoute($route1);
        $manager->persist($waypoint2);

        $waypoint3 = new Waypoint();
        $waypoint3->setTitle("33/33/3333 33:33");
        $waypoint3->setDescription("PUNTO DE PRUEBA");
        $waypoint3->setLatitude("3.3");
        $waypoint3->setLongitude("3.3");
        $waypoint3->setRoute($route1);
        $manager->persist($waypoint3);

        $manager->flush();
    }

}