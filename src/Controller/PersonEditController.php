<?php

namespace App\Controller;

use App\Form\PersonFormType;
use App\Repository\PersonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonEditController extends AbstractController
{
    #[Route('/{name}', name: 'person_edit_index')]
    public function index(string $name, PersonRepository $personRepository): Response
    {
        $person = $personRepository->findBy(['name' => $name]);

        if(count($person) == 0){
            return $this->redirectToRoute('homepage');
        }
        else if (count($person) == 1){
            return $this->redirectToRoute('person_edit', ['name' => $name, 'id' => $person[0]->getId()]);
        }

        return $this->render('homepage/index.html.twig', [
            'person' => $person,
        ]);
    }

    #[Route('/{name}/{id}', name: 'person_edit')]
    public function edit(string $name, string $id, PersonRepository $personRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $person = $personRepository->find($id);

        if ($person == null){
            return $this->redirectToRoute('person_edit_index', ['name' => $name]);
        }

        $form = $this->createForm(PersonFormType::class, $person);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $person = $form->getData();

            $entityManager->persist($person);
            $entityManager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('person_edit/edit.html.twig', [
            'form' => $form,
        ]);
    }
}
