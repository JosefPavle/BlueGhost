<?php

namespace App\Controller;

use App\Repository\PersonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonDeleteController extends AbstractController
{
    #[Route('/person_delete/{id}', name: 'person_delete')]
    public function index(string $id, EntityManagerInterface $entityManager, PersonRepository $personRepository, Request $request): Response
    {
        $person = $personRepository->find($id);

        if ($person != null){
            $entityManager->remove($person);
            $entityManager->flush();
        }

        $route = $request->headers->get('referer');

        return $this->redirect($route);
    }
}
