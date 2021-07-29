<?php

namespace App\Controller;

use App\Entity\Trips;
use App\Form\TripsType;
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

    public function new(Request $request): Response
    {
        $user = $this->getUser();
        $trip = new Trips();


        $organizer = $user->getCampus();
        $trip->setOrganizer($organizer);





        $form = $this->createForm(TripsType::class, $trip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($trip);
            $this->em->flush();
            return $this->redirectToRoute('trips_index');
        }

        return $this->render('trips/new.html.twig', [
            'form' => $form->createView(),
            'trip' => $trip,
            'user' => $user,
            'organizer' => $organizer,
        ]);
    }

    /**
     * @Route("/trips/delete/{id}", name="trips_delete")
     */
    public function delete(Request $request, Trips $trip): Response
    {
        $form = $this->createFormBuilder()
            ->add('delete', 'submit', ['label' => 'Delete'])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->remove($trip);
            $this->em->flush();
            return $this->redirectToRoute('trips_index');
        }
        return $this->render('trips/delete.html.twig', [
            'form' => $form->createView(),
            'trip' => $trip,
        ]);
    }

    /**
     * @Route("/trips/{id}/edit", name="trips_edit")
     */
    public function edit(Request $request, Trips $trip): Response
    {
        $form = $this->createForm(TripsType::class, $trip);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($trip);
            $this->em->flush();
            return $this->redirectToRoute('trips_index');
        }
        return $this->render('trips/new.html.twig', [
            'form' => $form->createView(),
            'trip' => $trip,
        ]);
    }
}
