<?php
declare( strict_types=1);

namespace App\Controller\ApiController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class TestController extends AbstractController{
    
    /**
     * @Route("/reactjs", name="app_project_type_type2", methods={"GET"})
     *
     * @return Response
     */
    public function index(): Response{

        $users = [
                [
                    "name"          => "Teguia polla",
                    "firstname"     => "joël"
                ],
                [
                    "name"      => "Teguia polla",
                    "firstname" => "joël"
                    
                ],
                [
                    "name"      => "Teguia polla",
                    "firstname" => "joël"
                    
                ],
            ];

        return $this->render("address/index.html.twig",["datat" => $users]);
    }

        /**
     * @Route("/api", name="app_project_type_type4", methods={"GET"})
     *
     * @return Response
     */
    public function api(): JsonResponse{

        $users = [
                [
                    "name"          => "Teguia polla",
                    "firstname"     => "joël"
                ],
                [
                    "name"      => "Teguia polla",
                    "firstname" => "joël"
                    
                ],
                [
                    "name"      => "Teguia polla",
                    "firstname" => "joël"
                    
                ],
                [
                    "name"      => "Teguia polla",
                    "firstname" => "joël"
                    
                ],
                [
                    "name"      => "Teguia polla",
                    "firstname" => "joël"
                    
                ],
                [
                    "name"      => "Teguia polla",
                    "firstname" => "joël"
                    
                ],
                [
                    "name"      => "Teguia polla",
                    "firstname" => "joël"
                    
                ],
                [
                    "name"      => "Teguia polla",
                    "firstname" => "joël"
                    
                ],
                [
                    "name"      => "Teguia polla",
                    "firstname" => "joël"
                    
                ]
            ];

            for( $i=0; $i<1000; $i++){
                $tab = [
                    "name"          => "Teguia polla",
                    "firstname"     => "joël"
                ];
                array_push($users, $tab);

            }

            return $this->json([
                'status'  => Response::HTTP_BAD_REQUEST,
                'users'   => $users
            ]);
    }
}