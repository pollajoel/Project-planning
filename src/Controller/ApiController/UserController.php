<?php

namespace App\Controller\ApiController;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
 

    /**
     *
     * @var entityManagerInterface
     */
    private $entityManager;

    /**
     *
     * @var SerializerInterface 
     */
    private $serializer;

    /**
     *
     * @var UserRepository 
     */
    private $userRepository;


    /**
     * 
     * @var  ValidatorInterface
     */
    private  $validator;

    /**
     * Undocumented function
     *
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     * @param UserRepository $userRepository
     * @param ValidatorInterface $validator
     */
    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer, UserRepository $userRepository, ValidatorInterface $validator)
    {

        $this->serializer        = $serializer;
        $this->entityManager     = $entityManager;
        $this->userRepository    = $userRepository;
        $this->validator         = $validator;
    }

    /**
     * @Route("/api/users", name="app_user", methods={"GET"})
     * @return Response
     */
    public function getUsers(): Response
    {
        return $this->json($this->userRepository->findAll(), Response::HTTP_OK, [], ["groups" => "user:read"]);
    }

    /**
     * @Route("/api/user/{id}", name="app_user_by_id", methods={"GET"})
     * @return Response
     */
    public function getUserById($id): Response
    {

        $user = $this->userRepository->findBy(array('id' => (int)$id));
        if (count($user) > 0) {
            return $this->json($user, Response::HTTP_OK, [],  ["groups" => "user:read"]);
        } else {
            return  $this->json($user, Response::HTTP_NOT_FOUND, [], ["groups" => "user:read"]);
        }
    }

    /**
     * @Route("/api/user", name="app_post_user", methods={"POST"})
     * @param request $request
     * @return Response
     */
    public function addUser(Request $request)
    {

        $requestParams = $request->getContent();
        try {

            $user = $this->serializer->deserialize($requestParams, User::class, "json", []);
            /*** check if the parameters pass to request is correct. ***/
            $errors = $this->validator->validate($user);
            if (count($errors) > 0) {
                return $this->json($errors, Response::HTTP_BAD_REQUEST, [], []);
            }

            $this->entityManager->persist($user);
            $this->entityManager->flush();
            return $this->json($user, Response::HTTP_CREATED, [], ["groups" => "user:read"]);
        } catch (NotEncodableValueException $e) {
            return $this->json(
                [
                    "status" =>  Response::HTTP_BAD_REQUEST,
                    "message" =>  $e->getMessage()
                ]
            );
        }
    }


    /**
     * Update user by Id
     * 
     * @Route("/api/user/{id}", name="app_update_user", methods={"PUT"})
     * @param Request $request
     * @return Response
     */
    public function updateUser(Request $request)
    {
        /**
         * @var string|resource $requestParams
         * @var User $user
         */

        $requestParams = $request->getContent();
        $user = $this->userRepository->find($request->get("id"));
        if( !$user ){
            return $this->json(["message"=>sprintf(" %s with id %s NOT FOUND", User::class, $request->get("id")), "status" => Response::HTTP_NOT_FOUND], Response::HTTP_NOT_FOUND);
        }
        
        try {

            $userNew = $this->serializer->deserialize($requestParams, User::class, 'json', []);
            $errors = $this->validator->validate($userNew);
            if (count($errors) > 0) {
                return $this->json($errors, Response::HTTP_BAD_REQUEST, [], []);
            }
            //$User->setTypeName($UserNew->getTypeName());
            $this->entityManager->flush();
            return  $this->json($user, Response::HTTP_CREATED, [], ["groups" => "project:read"]);
        
        }catch (NotEncodableValueException $e) {
                return $this->json(
                    [
                        'status' =>  Response::HTTP_BAD_REQUEST,
                        'message' =>  $e->getMessage()
                    ]
                );
        }

    }
}
