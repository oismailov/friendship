<?php

namespace Acme\FriendshipBundle\Controller;

use Acme\FriendshipBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * User controller.
 *
 * @Route("/user")
 */
class UserController extends Controller
{

    /**
     * Finds and displays a User entity.
     *
     * @Route("/{id}", name="user_show")
     * @Method("GET")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeFriendshipBundle:User')->find($id);

        if (!$entity) {
            $jsonHelper = $this->get('app.json_helper');
            return new JsonResponse($jsonHelper->renderJsonError('user was not found'), Response::HTTP_NOT_FOUND);
        }
        $serializer = $this->container->get('serializer');
        $user = $serializer->serialize($entity, 'json');

        return new Response($user, Response::HTTP_OK, array('Content-Type' => 'application/json'));

    }

}
