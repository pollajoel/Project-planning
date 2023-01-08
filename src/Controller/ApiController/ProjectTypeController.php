<?php

namespace App\Controller\ApiController;

use App\Entity\ProjectType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProjectTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProjectTypeController extends AbstractController
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
     * @var ProjectTypeRepository
     */
    private $projectTypeRepository;


    /**
     * 
     * @var  ValidatorInterface
     */
    private  $validator;

    /**
     * projectType constructor
     *
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     * @param ProjectTypeRepository $projectTypeRepository
     * @param ValidatorInterface $validator
     */
    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer, ProjectTypeRepository $projectTypeRepository, ValidatorInterface $validator)
    {

        $this->serializer        = $serializer;
        $this->entityManager     = $entityManager;
        $this->projectTypeRepository = $projectTypeRepository;
        $this->validator         = $validator;
    }

    /**
     * @Route("/api/projecttypes", name="app_project_type", methods={"GET"})
     * @return Response
     */
    public function getProjectsType(): Response
    {
        return $this->json($this->projectTypeRepository->findAll(), Response::HTTP_OK, [], ["groups" => "project:read"]);
    }

    /**
     * @Route("/api/projecttype/{id}", name="app_project_type_by_id", methods={"GET"})
     * @return Response
     */
    public function getProjectsTypeById($id): Response
    {

        $projectType = $this->projectTypeRepository->findBy(array('id' => (int)$id));
        if (count($projectType) > 0) {
            return $this->json($projectType, Response::HTTP_OK, [],  ["groups" => "project:read"]);
        } else {
            return  $this->json($projectType, Response::HTTP_NOT_FOUND, [], ["groups" => "project:read"]);
        }
    }

    /**
     * @Route("/api/projecttype", name="app_post_project_tye", methods={"POST"})
     * @param request $request
     * @return Response
     */
    public function addProjectType(Request $request)
    {

        $requestParams = $request->getContent();
        try {

            $projectType = $this->serializer->deserialize($requestParams, ProjectType::class, "json", []);
            /*** check if the parameters pass to request is correct. ***/
            $errors = $this->validator->validate($projectType);
            if (count($errors) > 0) {
                return $this->json($errors, Response::HTTP_BAD_REQUEST, [], []);
            }

            $this->entityManager->persist($projectType);
            $this->entityManager->flush();
            return $this->json($projectType, Response::HTTP_CREATED, [], ["groups" => "project:read"]);
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
     * Update project by Id
     * 
     * @Route("/api/projecttype/{id}", name="app_update_project_type", methods={"PUT"})
     * @param Request $request
     * @return Response
     */
    public function updateProjectType(Request $request)
    {
        /**
         * @var string|resource $requestParams
         * @var ProjectType $projectType
         */

        $requestParams = $request->getContent();
        $projectType = $this->projectTypeRepository->find($request->get("id"));
        if( !$projectType ){
            return $this->json(["message"=>sprintf(" %s with id %s NOT FOUND", ProjectType::class, $request->get("id")), "status" => Response::HTTP_NOT_FOUND], Response::HTTP_NOT_FOUND);
        }
        
        try {

            $projectTypeNew = $this->serializer->deserialize($requestParams, ProjectType::class, 'json', []);
            $errors = $this->validator->validate($projectTypeNew);
            if (count($errors) > 0) {
                return $this->json($errors, Response::HTTP_BAD_REQUEST, [], []);
            }
            $projectType->setTypeName($projectTypeNew->getTypeName());
            $this->entityManager->flush();
            return  $this->json($projectType, Response::HTTP_CREATED, [], ["groups" => "project:read"]);
        
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
