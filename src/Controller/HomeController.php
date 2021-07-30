<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\State;
use App\Repository\CampusRepository;
use App\Repository\UserRepository;
use App\Repository\TripsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
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
    public function index(TripsRepository $tripRepo, CampusRepository $campusRepo): Response
    {

        $user = $this->getUser();
        $trips = $tripRepo->findAll();
        $campus = $campusRepo->findAll();

        dump($campus);

        return $this->render('home/home.html.twig', [
            'user' => $user,
            'trips' => $trips,
            'campus' => $campus,

        ]);
    }
}
