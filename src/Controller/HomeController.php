<?php

namespace App\Controller;

use App\Entity\TripSearch;
use App\Form\TripSearchType;
use App\Repository\UserRepository;
use App\Repository\TripsRepository;
use App\Repository\CampusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    public function __construct(EntityManagerInterface $em, UserRepository $repo)
    {
        $this->em = $em;
        $this->repo = $repo;
    }

    /**
     * @Route("/home", name="home_")
     */
    public function index(TripsRepository $tripRepo, CampusRepository $campusRepo, Request $request): Response
    {

        $userId = $this->getUser()->getId();
        $user = $this->repo->find($userId);
        dump($userId);


        $trips = $tripRepo->findAll();
        $campus = $campusRepo->findAll();

        $search = new TripSearch();

        $form = $this->createForm(TripSearchType::class, $search);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData();
            $trips = $tripRepo->getAllTrips($search, $userId);
        }

        return $this->render('home/home.html.twig', [
            'user' => $user,
            'trips' => $trips,
            'campus' => $campus,
            'form' => $form->createView()

        ]);
    }
}
