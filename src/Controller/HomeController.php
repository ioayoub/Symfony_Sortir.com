<?php

namespace App\Controller;

use App\Entity\TripSearch;
use App\Form\TripSearchType;
use App\Repository\UserRepository;
use App\Repository\TripsRepository;
use App\Repository\CampusRepository;
use App\Repository\StateRepository;
use DateTime;
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
    public function index(TripsRepository $tripRepo, CampusRepository $campusRepo, Request $request, StateRepository $stateRepo, EntityManagerInterface $em): Response
    {

        $user = $this->getUser();
        $userId = $this->getUser()->getId();

        $trips = $tripRepo->findAll();
        $campus = $campusRepo->findAll();

        $search = new TripSearch();

        $form = $this->createForm(TripSearchType::class, $search);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData();
            $trips = $tripRepo->getAllTrips($search, $userId);
        }

        foreach ($trips as $trip) {
            $registered = $trip->getIsSubscribed()->contains($user);
            $nbRegistered = $trip->getIsSubscribed()->count();
            $trip->setIsRegistered($registered);
            $nbRegistered = $trip->getMaxRegistrations() - $nbRegistered;

            $today = new \DateTime();

            //state 2 = Open
            if ($today <= $trip->getLimitRegisterDate() && $trip->getNbRegistered() < $trip->getMaxRegistrations()) {
                $trip->setState($stateRepo->find(2));
            }
            //State 3 = Closed
            if ($today > $trip->getLimitRegisterDate() || $trip->getNbRegistered() == $trip->getMaxRegistrations()) {
                $trip->setState($stateRepo->find(3));
            }
            //State 4 = In progress
            if ($today > $trip->getLimitRegisterDate() && $today == $trip->getDateStart($trip->getDateStart('PT' . $trip->getDuration() . 'M'))) {
                $trip->setState($stateRepo->find(4));
            }
            //State 5 = Ended
            if ($today > $trip->getDateStart() && $today > $trip->getLimitRegisterDate() &&  $today > $trip->getDateStart($trip->getDateStart('PT' . $trip->getDuration() . 'M'))) {
                $trip->setState($stateRepo->find(5));
            }
            //State 6 = canceled

            //State 7 = Archived
            if ($trip->getLimitRegisterDate() > $trip->getDateStart($trip->getLimitRegisterDate('PT30D'))) {
                $trip->setState($stateRepo->find(7));
            }

            $em->flush();
        }

        return $this->render('home/home.html.twig', [
            'user' => $user,
            'trips' => $trips,
            'campus' => $campus,
            'form' => $form->createView(),



        ]);
    }
}
