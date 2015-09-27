<?php

namespace Acme\FriendshipBundle\Controller;

use Acme\FriendshipBundle\Entity\Relationship;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Relationship controller.
 *
 * @Route("/relationship")
 */
class RelationshipController extends Controller
{

    const SUCCESSFULLY_CREATED = 'relationship was successfully created';
    const INVALID_PARAMETERS = 'Invalid input parameters';
    const RELATIONSHIP_EXISTS = 'relationship already exists';
    const RELATIONSHIP_DOES_NOT_EXIST = 'relationship does not exist';
    const SUCCESSFULLY_DELETED = 'relationship was successfully deleted';

    /**
     * Creates a new Relationship entity.
     *
     * @Route("/new", name="relationship_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {

        $validation = $this->get('app.validation');

        $id = $request->request->get('user_one_id');
        $id2 = $request->request->get('user_two_id');

        $userOneId = $validation->validateInteger($id) ? $id : false;
        $userTwoId = $validation->validateInteger($id2) ? $id2 : false;

        if ($userOneId && $userTwoId && ($userOneId != $userTwoId)) {

            $relationship = new Relationship();

            $em = $this->getDoctrine()->getEntityManager();
            $relationshipEntity = $this->getDoctrine()->getRepository('Acme\FriendshipBundle\Entity\Relationship');

            $userOne = $em->find('Acme\FriendshipBundle\Entity\User', $userOneId);
            $userTwo = $em->find('Acme\FriendshipBundle\Entity\User', $userTwoId);
            if ($userOne && $userTwo) {

                if ($relationshipEntity->findOneBy(
                    array(
                        'user_one_id' => $userOneId,
                        'user_two_id' => $userTwoId))
                    || $relationshipEntity->findOneBy(array(
                        'user_one_id' => $userTwoId,
                        'user_two_id' => $userOneId))) {
                    $responseArray = array('message' => self::RELATIONSHIP_EXISTS);
                    $responseStatus = Response::HTTP_OK;
                } else {
                    $relationship->setUserOneId($userOne);
                    $relationship->setUserTwoId($userTwo);
                    $em->persist($relationship);
                    $em->flush();

                    $responseArray = array('message' => self::SUCCESSFULLY_CREATED);
                    $responseStatus = Response::HTTP_OK;}
            } else {
                $jsonHelper = $this->get('app.json_helper');
                $responseArray = $jsonHelper->renderJsonError(self::INVALID_PARAMETERS);
                $responseStatus = Response::HTTP_BAD_REQUEST;
            }

        } else {
            $jsonHelper = $this->get('app.json_helper');
            $responseArray = $jsonHelper->renderJsonError(self::INVALID_PARAMETERS);
            $responseStatus = Response::HTTP_BAD_REQUEST;
        }

        return new JsonResponse($responseArray, $responseStatus);

    }

    /**
     * Finds and displays a Relationship entity.
     *
     * @Route("/{id}", name="relationship_show")
     * @Method("GET")
     */
    public function showAction($id)
    {

        $validation = $this->get('app.validation');

        if (!$validation->validateInteger($id)) {
            $jsonHelper = $this->get('app.json_helper');
            return new JsonResponse($jsonHelper->renderJsonError(self::INVALID_PARAMETERS), Response::HTTP_BAD_REQUEST);

        }

        $em = $this->getDoctrine()->getManager();

        $relationship = new Relationship();

        $user = $em->find('Acme\FriendshipBundle\Entity\User', $id);
        if (!$user) {
            $jsonHelper = $this->get('app.json_helper');
            return new JsonResponse($jsonHelper->renderJsonError(self::INVALID_PARAMETERS), Response::HTTP_BAD_REQUEST);
        }

        $query = $em->createQuery('
            SELECT
                IDENTITY(r.user_one_id) AS user_two_id,
                IDENTITY(r.user_two_id) AS user_one_id
            FROM AcmeFriendshipBundle:Relationship r
            WHERE r.user_one_id = :user_id
                OR r.user_two_id = :user_id'
        )->setParameter('user_id', $id);

        $entities = $query->getResult();

        $friendsId = array();

        foreach ($entities as $entity) {
            if ($id !== $entity['user_one_id']) {
                $friendsId[] = (int) $entity['user_one_id'];
            }

            if ($id !== $entity['user_two_id']) {
                $friendsId[] = (int) $entity['user_two_id'];
            }
        }

        return new JsonResponse($friendsId, Response::HTTP_OK);
    }

    /**
     * Deletes a Relationship entity.
     *
     * @Route("/delete/{id}/{id2}", name="relationship_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id, $id2)
    {
        $validation = $this->get('app.validation');

        $userOneId = $validation->validateInteger($id) ? $id : false;
        $userTwoId = $validation->validateInteger($id2) ? $id2 : false;

        if ($userOneId && $userTwoId && ($userOneId != $userTwoId)) {

            $relationship = new Relationship();

            $em = $this->getDoctrine()->getEntityManager();
            $relationshipEntity = $this->getDoctrine()->getRepository('Acme\FriendshipBundle\Entity\Relationship');

            $userOne = $em->find('Acme\FriendshipBundle\Entity\User', $userOneId);
            $userTwo = $em->find('Acme\FriendshipBundle\Entity\User', $userTwoId);
            if ($userOne && $userTwo) {
                $entity = $relationshipEntity
                    ->findOneBy(
                        array(
                            'user_one_id' => $userOneId,
                            'user_two_id' => $userTwoId));
                $entity2 = $relationshipEntity
                    ->findOneBy(
                        array(
                            'user_one_id' => $userTwoId,
                            'user_two_id' => $userOneId));
                if (!$entity && !$entity2) {
                    $responseArray = array('message' => self::RELATIONSHIP_DOES_NOT_EXIST);
                    $responseStatus = Response::HTTP_OK;
                } else {
                    if ($entity) {
                        $em->remove($entity);
                    }
                    if ($entity2) {
                        $em->remove($entity2);
                    }
                    $em->flush();

                    $responseArray = array('message' => self::SUCCESSFULLY_DELETED);
                    $responseStatus = Response::HTTP_OK;}
            } else {
                $jsonHelper = $this->get('app.json_helper');
                $responseArray = $jsonHelper->renderJsonError(self::INVALID_PARAMETERS);
                $responseStatus = Response::HTTP_BAD_REQUEST;
            }

        } else {
            $jsonHelper = $this->get('app.json_helper');
            $responseArray = $jsonHelper->renderJsonError(self::INVALID_PARAMETERS);
            $responseStatus = Response::HTTP_BAD_REQUEST;
        }

        return new JsonResponse($responseArray, $responseStatus);

    }

}
