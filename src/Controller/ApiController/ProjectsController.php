<?php

namespace App\Controller\ApiController;

use App\Repository\ProjectsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Projects;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class ProjectsController extends AbstractController
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
     * @var  ProjectsRepository
     */
    private  $projectRepository;

    /**
     * 
     * @var  ValidatorInterface
     */
    private  $validator;

    /**
     *
     * @param entityManagerInterface $entityManager
     * @param SerializerInterface    $serializer
     * @param ProjectsRepository     $projectRepository
     */
    public function __construct(entityManagerInterface $entityManager, SerializerInterface $serializer, ProjectsRepository $projectRepository, ValidatorInterface $validator)
    {

        $this->serializer        = $serializer;
        $this->entityManager     = $entityManager;
        $this->projectRepository = $projectRepository;
        $this->validator         = $validator;
    }

    /**
     * Get All projects 
     * 
     * @Route("/api/projects", name="app_get_all_project", methods={"GET"})
     * @return Response
     */
    public function getProjects()
    {
        return $this->json($this->projectRepository->findAll(), Response::HTTP_OK, [], ["groups" => "project:read"]);
    }

    /**
     * Get project By Id
     *
     * @Route("/api/project/{id}", name="app_get_project_by_id", methods={"GET"})
     * @return Response
     */
    public function getProjectById($id)
    {

        $projects = $this->projectRepository->findBy(array('id' => (int)$id));
        if (count($projects) > 0) {
            return $this->json($projects, Response::HTTP_OK, [],  []);
        } else {
            return  $this->json($projects, Response::HTTP_NOT_FOUND, [], []);
        }
    }

    /**
     * @Route("/api/project", name="app_post_project", methods={"POST"})
     * @param request $request
     * @return Response
     */
    public function addProject(Request $request)
    {

        $requestParams = $request->getContent();
        try {

            $project = $this->serializer->deserialize($requestParams, projects::class, "json", []);
            /*** check if the parameters pass to request is correct. ***/
            $errors = $this->validator->validate($project);
            if (count($errors) > 0) {
                return $this->json($errors, Response::HTTP_BAD_REQUEST, [], []);
            }

            $this->entityManager->persist($project);
            $this->entityManager->flush();
            return $this->json($project, Response::HTTP_CREATED, [], ["groups" => "project:read"]);
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
     * @Route("/api/project/{id}", name="app_update_project", methods={"PUT"})
     * @param Request $request
     * @return Response
     */
    public function updateProject(Request $request, $id)
    {
        /**
         * @var string|resource $requestParams
         * @var Projects[] $project
         * @var Projects $projectNew
         */

        $requestParams = $request->getContent();
        $project = $this->projectRepository->findBy(array('id' => (int)$id));

        if (count($project) > 0) {

            try {

                $projectNew = $this->serializer->deserialize($requestParams, projects::class, 'json', []);
                $errors = $this->validator->validate($projectNew);
                if (count($errors) > 0) {
                    return $this->json($errors, Response::HTTP_BAD_REQUEST, [], []);
                }

                $this->entityManager->remove($project[0]);
                $this->entityManager->persist($projectNew);
                $this->entityManager->flush();
                return $this->json($project, Response::HTTP_CREATED, [], []);
            } catch (NotEncodableValueException $e) {
                return $this->json(
                    [
                        'status' =>  Response::HTTP_BAD_REQUEST,
                        'message' =>  $e->getMessage()
                    ]
                );
            }
        } else {
            return $this->json(['status' => Response::HTTP_NOT_FOUND,]);
        }
    }
}
