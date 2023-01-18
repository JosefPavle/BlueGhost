<?php

namespace App\Controller;

use App\Entity\Person;
use App\Repository\PersonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(PersonRepository $personRepository): Response
    {
        $person = $personRepository->findAll();

        return $this->render('homepage/index.html.twig', [
            'person' => $person,
        ]);
    }
}
