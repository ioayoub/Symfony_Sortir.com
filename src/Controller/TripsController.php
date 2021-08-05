<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\State;
use App\Entity\Trips;
use App\Form\TripsType;
use App\Repository\TripsRepository;
use App\Repository\CampusRepository;
use App\Repository\CityRepository;
use App\Repository\PlaceRepository;
use App\Repository\StateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TripsController extends AbstractController
{

    public function __construct(TripsRepository $repo, EntityManagerInterface $em)
    {
        $this->repo = $repo;
        $this->em = $em;
    }

    /**
     * @Route("/trips", name="trips_index")
     */
    public function index(): Response
    {
        $trips = $this->repo->findAll();


        return $this->render('home/home.html.twig', [
            'controller_name' => 'TripsController',
            'trips' => $trips,
        ]);
    }

    /**
     * @Route("/trips/new", name="trips_new")
     */

    public function new(Request $request, CampusRepository $campRepo, StateRepository $stateRepo, PlaceRepository $placeRepo): Response
    {
        $trip = new Trips();
        $campus = $campRepo->findAll();
        $user = $this->getUser();
        $place = $placeRepo->findAll();

        $form = $this->createForm(TripsType::class, $trip);
        $form->handleRequest($request);


        dump($trip->getState());

        $organizer = $user->getCampus();
        $trip->setOrganizer($organizer);

        $isOrganizer = $this->getUser();
        $trip->setIsOrganizer($isOrganizer);


        if ($form->isSubmitted() && $form->isValid()) {


            $trip->setState($stateRepo->find(1));

            $this->em->persist($trip);
            $this->em->flush();
            return $this->redirectToRoute('home_');
        }

        return $this->render('trips/new.html.twig', [
            'form' => $form->createView(),
            'trip' => $trip,
            'user' => $user,
            'campus' => $campus,
            'place' => $place,
        ]);
    }

    /**
     * @Route("/trips/delete/{id}", name="trips_delete")
     */
    public function delete(int $id): Response
    {
        $trip = $this->repo->find($id);

        $this->em->remove($trip);
        $this->em->flush();
        return $this->redirectToRoute('home_');
    }

    /**
     * @Route("/trips/edit/{id}", name="trips_edit")
     */
    public function edit(int $id, Request $request, CampusRepository $campRepo, PlaceRepository $placeRepo): Response
    {
        $trip = $this->repo->find($id);
        $campus = $campRepo->findAll();
        $place = $placeRepo->findAll();


        $form = $this->createForm(TripsType::class, $trip);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $trip->setNbRegistered(0);
            $trip->setNbRegistered($trip->getNbRegistered() + $trip->getIsSubscribed()->count());



            $this->em->persist($trip);

            $this->em->flush();
            return $this->redirectToRoute('home_');
        }
        return $this->render('trips/new.html.twig', [
            'form' => $form->createView(),
            'trip' => $trip,
            'editMode' => $trip->getId(),
            'campus' => $campus,
            'place' => $place,
        ]);
    }

    /**
     * @Route("/trips/show/{id}", name="trips_show")
     */
    public function show(int $id, CampusRepository $campRepo): Response
    {
        $trip = $this->repo->find($id);
        $campus = $campRepo->findAll();
        $user = $this->getUser();
        $isSubscribed = $trip->getIsSubscribed($user);



        dump($trip);

        return $this->render('trips/show.html.twig', [
            'trip' => $trip,
            'campus' => $campus,
            'isSubscribed' => $isSubscribed,

        ]);
    }
    /**
     * @Route("/trips/subscribe/{id}", name="trips_subscribe")
     */
    public function subscribe($id): Response
    {
        $trip = $this->repo->find($id);
        $user = $this->getUser();
        $user->addIsSubscribedId($trip);
        $trip->setNbRegistered($trip->getNbRegistered() + 1);
        $this->em->persist($trip);
        $this->em->flush();
        return $this->redirectToRoute('home_');
    }

    /**
     * @Route("/trips/unsubscribe/{id}", name="trips_unsubscribe")
     */
    public function unsubscribe($id): Response
    {
        $trip = $this->repo->find($id);
        $user = $this->getUser();
        $user->removeIsSubscribedId($trip);
        $trip->setNbRegistered($trip->getNbRegistered() - 1);

        $this->em->persist($trip);
        $this->em->flush();
        return $this->redirectToRoute('home_');
    }

    /**
     * @Route("/trips/publish/{id}", name="trips_publish")
     */
    public function publish($id, StateRepository $stateRepo): Response
    {
        $trip = $this->repo->find($id);
        $trip->setState($stateRepo->find(2));
        $this->em->persist($trip);
        $this->em->flush();
        return $this->redirectToRoute('home_');
    }
}
