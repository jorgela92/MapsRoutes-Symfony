<?php

namespace ApiBundle\Controller;

use CoreBundle\Entity\User;
use CoreBundle\Entity\Waypoint;
use CoreBundle\Model\RouteModel;
use CoreBundle\Model\UserModel;
use CoreBundle\Model\WaypointModel;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializationContext;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

/**
 * @Route("/api/v1")
 */

class DefaultController extends FOSRestController{
    /**
     * @Post("/login/{email}/{password}")
     */
    public function loginAction($email, $password)
    {
        $view = View::create();
        $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
        $serializationContext = SerializationContext::create()->enableMaxDepthChecks();
        $user_manager = $this->container->get('corebundle.model.usermodel');
        $user = $user_manager->findUserByEmail($email);
        $pass = $encoder->encodePassword(
            $password, $user->getSalt());
        $user = $user_manager->findUserByLogin($email, $pass);
        if (!$user) {
            $view
                ->setData("Validation Failed")
                ->setStatusCode(Codes::HTTP_BAD_REQUEST)
                ->setSerializationContext($serializationContext);
        } else {
            $view
                ->setData($user)
                ->setStatusCode(Codes::HTTP_OK)
                ->setSerializationContext($serializationContext);
        }
        return $view;
    }

    /**
     * @Get("/routes/{userid}")
     */
    public function userRoutesAction(Request $request, $userid)
    {

        $view = View::create();

        /** @var RouteModel $model */
        $model = $this->get("corebundle.model.routemodel");
        /** @var Route $elementos */
        $elementos = $model->findListByUserId($userid);

        $serializationContext = SerializationContext::create()->enableMaxDepthChecks();
        $view
            ->setData($elementos)
            ->setStatusCode(Codes::HTTP_OK)
            ->setSerializationContext($serializationContext);

        return $view;
    }
    /**
     * @Post("/addroute/{userid}")
     */
    public function postAddRouteAction(Request $request, $userid)
    {
        $view = View::create();
        $data = $request->request->all();
        /** @var UsereModel $model */
        $model = $this->get("corebundle.model.usermodel");
        /** @var User $elementos */
        $elementos = $model->findUserById($userid);
        /** @var Route $route */
        $route= new \CoreBundle\Entity\Route();
        $route->setTitle($data["title"]);
        $route->setDescription($data["desciption"]);
        $route->setUser($elementos);

        /** @var RouteModel $routeModel */
        $routeModel = $this->get("corebundle.model.routemodel");
        $routeModel->add($route);
        $routeModel->applyChanges();

        $serializationContext = SerializationContext::create()->enableMaxDepthChecks();
        $view
            ->setData($route)
            ->setStatusCode(Codes::HTTP_CREATED)
            ->setSerializationContext($serializationContext);

        return $view;
    }
    /**
     * @Post("/addwaypoint/{routeid}")
     */
    public function postAddWaypointAction(Request $request, $routeid)
    {
        $view = View::create();
        $data = $request->request->all();
        /** @var RouteModel $model */
        $model = $this->get("corebundle.model.routemodel");
        /** @var Route $elementos */
        $elementos = $model->findById($routeid);
        /** @var Waypoint $waypoint */
        $waypoint= new Waypoint();
        $waypoint->setTitle($data["title"]);
        $waypoint->setDescription($data["description"]);
        $waypoint->setLatitude($data["latitude"]);
        $waypoint->setLongitude($data["longitude"]);
        $waypoint->setRoute($elementos);

        /** @var WaypointModel $waitponitModel */
        $waitponitModel = $this->get("corebundle.model.waypointmodel");
        $waitponitModel->add($waypoint);
        $waitponitModel->applyChanges();

        $serializationContext = SerializationContext::create()->enableMaxDepthChecks();
        $view
            ->setData($waypoint)
            ->setStatusCode(Codes::HTTP_CREATED)
            ->setSerializationContext($serializationContext);

        return $view;
    }
}