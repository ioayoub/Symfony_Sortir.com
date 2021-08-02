<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Trips;
use App\Form\TripsType;
use App\Repository\CampusRepository;
use App\Repository\TripsRepository;
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

    public function new(Request $request, CampusRepository $campRepo): Response
    {
        $user = $this->getUser();
        $trip = new Trips();
        $campus = $campRepo->findAll();

        $organizer = $user->getCampus();

        $form = $this->createForm(TripsType::class, $trip);
        $form->handleRequest($request);

        $trip->setOrganizer($organizer);

        $user = new User();
        $isOrganizer = $this->getUser();
        $trip->setIsOrganizer($isOrganizer);


        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($trip);
            $this->em->flush();
            return $this->redirectToRoute('home_');
        }


        return $this->render('trips/new.html.twig', [
            'form' => $form->createView(),
            'trip' => $trip,
            'user' => $user,
            'organizer' => $organizer,
            'campus' => $campus,
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
    public function edit(int $id, Request $request, CampusRepository $campRepo): Response
    {
        $trip = $this->repo->find($id);
        $campus = $campRepo->findAll();

        $form = $this->createForm(TripsType::class, $trip);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $this->em->persist($trip);

            $this->em->flush();
            return $this->redirectToRoute('home_');
        }
        return $this->render('trips/new.html.twig', [
            'form' => $form->createView(),
            'trip' => $trip,
            'editMode' => $trip->getId(),
            'campus' => $campus,
        ]);
    }

    /**
     * @Route("/trips/show/{id}", name="trips_show")
     */
    public function show(int $id, CampusRepository $campRepo): Response
    {
        $trip = $this->repo->find($id);
        $campus = $campRepo->findAll();



        return $this->render('trips/show.html.twig', [
            'trip' => $trip,
            'campus' => $campus,



        ]);
    }
}
