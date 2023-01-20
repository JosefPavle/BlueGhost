<?php

namespace App\Controller;

use App\Repository\PersonRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(PersonRepository $personRepository, Request $request): Response
    {
        $page = $request->query->get('page');
        if(!is_numeric($page) OR $page == 0){
            $page = 1;
        }

        $personQuery = $personRepository->createQueryBuilder('person');

        $pagerfanta = new Pagerfanta(new QueryAdapter($personQuery));
        $pagerfanta->setMaxPerPage(5);
        $pagerfanta->setNormalizeOutOfRangePages(true);
        $pagerfanta->setCurrentPage($page);

        return $this->render('homepage/index.html.twig', [
            'personQuery' => $pagerfanta,
        ]);
    }
}
