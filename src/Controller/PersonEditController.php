<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonEditController extends AbstractController
{
    #[Route('/{name}', name: 'person_edit')]
    public function index(string $name): Response
    {

        return $this->render('person_edit/index.html.twig', [
            'name' => $name,
        ]);
    }
}
