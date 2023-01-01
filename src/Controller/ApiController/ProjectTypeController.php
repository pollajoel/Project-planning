<?php

namespace App\Controller\ApiController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectTypeController extends AbstractController
{
    /**
     * @Route("/api/project/type", name="app_project_type")
     */
    public function index(): Response
    {
        return $this->render('project_type/index.html.twig', [
            'controller_name' => 'ProjectTypeController',
        ]);
    }
}
