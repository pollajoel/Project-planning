<?php

namespace App\Controller\ApiController;


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

    private UserRepository $userRepository;
    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }
    /**
     * @Route("/user/lists", name="app_get_all_project", methods={"GET"})
     */
    public function listUsers(Request $request){

        /** @var array $allUsers */
        $allUsers =  $this->userRepository->findAll();

        if( $allUsers ){
            return $this->render('user/index.html.twig',[]);
        }else
        {
            return $this->render('user/index.html.twig',[]);
        }
    }
}