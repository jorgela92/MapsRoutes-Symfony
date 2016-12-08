<?php

namespace CoreBundle\Controller;

use CoreBundle\Entity\Relationship;
use CoreBundle\Entity\Role;
use CoreBundle\Entity\User;
use CoreBundle\Entity\Waypoint;
use CoreBundle\Model\RelationshipModel;
use CoreBundle\Model\RoleModel;
use CoreBundle\Model\RouteModel;
use CoreBundle\Model\typeGenderModel;
use CoreBundle\Model\UserModel;
use CoreBundle\Model\WaypointModel;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;


/**
 * @Route("/admin")
 */
class DefaultController extends Controller
{


    //Login action
    public function loginAction(Request $request)
    {
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('@Core/Default/login.html.twig', array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }

    /**
     * @Route("/dashboard",name="dashboard")
     * @Template()
     */
    public function dashboardAction(Request $request)
    {
        $securityContext = $this->get("security.context");
        /** @var User $user */
        $user = $securityContext->getToken()->getUser();

        /** @var RouteModel $model */
        $model = $this->get("corebundle.model.routemodel");
        /** @var ArrayCollection<Route> $elementos */

        if ( in_array("ROLE_ADMIN", $user->getRoles()) ) {
            $elementos = $model->findAll();
        }else{
            $elementos = $model->findListByUserId($user->getId());
        }

        return $this->render('@Core/Default/dashboard.html.twig',
            array('elementos' => $elementos,'user'=>$user)
        );
    }


    /**
     * @Route("/route",name="route")
     * @Template()
     */
    public function loadRouteDetailAction(Request $request)
    {
        $securityContext = $this->get("security.context");
        /** @var User $user */
        $user = $securityContext->getToken()->getUser();

        //routeId
        $routeId=$request->query->get('routeId');

        /** @var RouteModel $model */
        $model = $this->get("corebundle.model.routemodel");
        /** @var Route $elemento */
        $elemento=$model->findById($routeId);

        /** @var WaypointModel $modelWaypoint */
        $modelWaypoint = $this->get("corebundle.model.waypointmodel");
        /** @var ArrayCollection<Waypoint> $waypoint */
        $waypoints=$modelWaypoint->findByRouteId($routeId);

        return $this->render('@Core/Default/route_detail.html.twig',
            array('routeId' => $routeId ,'elemento' => $elemento,'waypoints' => $waypoints,'user'=>$user)
        );
    }

}//class
