<?php

namespace App\Controller;

use App\Form\PersonFormType;
use App\Repository\PersonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonEditController extends AbstractController
{
    #[Route('/{name}', name: 'person_edit_index')]
    public function index(string $name, PersonRepository $personRepository, Request $request): Response
    {
        $page = $request->query->get('page');
        if(!is_numeric($page) OR $page == 0){
            $page = 1;
        }

        $personQuery = $personRepository->createQueryBuilder('person')->where('person.name = :name')->setParameter('name', $name);

        $pagerfanta = new Pagerfanta(new QueryAdapter($personQuery));
        $pagerfanta->setMaxPerPage(5);
        $pagerfanta->setNormalizeOutOfRangePages(true);

        if($pagerfanta->getNbResults() == 0){
            $this->addFlash('notification', 'No Person With Name "' . $name . '" Found!');

            return $this->redirectToRoute('homepage');
        }
        else if ($pagerfanta->getNbResults() == 1){
            return $this->redirectToRoute('person_edit', ['name' => $name, 'id' => $pagerfanta->getCurrentPageResults()[0]->getId()]);
        }

        $pagerfanta->setCurrentPage($page);

        return $this->render('homepage/index.html.twig', [
            'personQuery' => $pagerfanta,
        ]);
    }

    #[Route('/{name}/{id}', name: 'person_edit')]
    public function edit(string $name, string $id, PersonRepository $personRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $person = $personRepository->find($id);

        if ($person == null || $person->getName() != $name){
            $this->addFlash('notification', 'No "' . $name . '" With ID "' . $id . '" Found!');
            return $this->redirectToRoute('person_edit_index', ['name' => $name]);
        }

        $form = $this->createForm(PersonFormType::class, $person);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $person = $form->getData();

            $entityManager->persist($person);
            $entityManager->flush();

            $this->addFlash('notification', 'Person "' . $name . '" Successfully Updated!');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('person_edit/edit.html.twig', [
            'form' => $form,
        ]);
    }
}
