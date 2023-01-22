<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonFormType;
use App\Services\ValidationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonCreateController extends AbstractController
{
    #[Route('/create', name: 'person_create')]
    public function index(Request $request, EntityManagerInterface $entityManager, ValidationService $validator): Response
    {
        $person = new Person();
        $form = $this->createForm(PersonFormType::class, $person);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $person = $form->getData();

            if ($validator->ValidateData($person)){
                $entityManager->persist($person);
                $entityManager->flush();

                $this->addFlash('notification', 'Person Successfully Created!');

                return $this->redirectToRoute('homepage');
            }
        }

        return $this->render('person_create/index.html.twig', [
            'form' => $form,
        ]);
    }
}
