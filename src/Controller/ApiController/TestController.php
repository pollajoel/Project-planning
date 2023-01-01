<?php
declare( strict_types=1);

namespace App\Controller\ApiController;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class TestController extends AbstractController{
    
    public function index(): Response{

        return new Response("Hello", http_response_code(200));
    }
}