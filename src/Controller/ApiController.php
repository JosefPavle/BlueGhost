<?php

namespace App\Controller;

use App\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    #[Route('/api/getPersonDescription/{id}', name: 'api')]
    public function index(Person $person, SerializerInterface $serializer): Response
    {
        $json = $serializer->serialize($person->getDescription(), "json");


        //return new Response($person->getDescription(), 200);
        return new JsonResponse($json, 200, [], true);
    }
}
