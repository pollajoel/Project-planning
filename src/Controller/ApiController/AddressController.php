<?php

namespace App\Controller\ApiController;

use App\Entity\Address;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddressController extends AbstractController
{
    /**
     * @Route("/api/address", name="app_address", methods={"GET"})
     */
    public function index(AddressRepository $AddressRepo): Response
    {
        /*
            $json = $serializer->serialize( $AddressRepo->findAll(), 'json');
            $response = new JsonResponse($json, 200, [], true );
        */
        return $this->json($AddressRepo->findAll(), Response::HTTP_OK, [],  ["groups" => "address:read"]);
    }

    /**
     * @Route("/api/address", name="app_address_post", methods={"POST"})
     * @throws Exception
     */
    public function addAddress(Request $request, SerializerInterface $serialize, EntityManagerInterface $em, ValidatorInterface $validator): Response
    {
        $params = $request->getContent();
        try {

            $address = $serialize->deserialize($params, Address::class, 'json', []);
            $em->persist($address);
            $em->flush();
            return $this->json($address, response::HTTP_CREATED, [], ["groups" => "address:read"]);
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'status'  => Response::HTTP_BAD_REQUEST,
                'message' => $e->getMessage()
            ]);
        }
    }
}
