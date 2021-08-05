<?php

namespace App\Controller;

use App\Entity\Place;
use App\Form\PlaceType;
use App\Repository\PlaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PlaceController extends AbstractController
{

    public function __construct(PlaceRepository $repo, EntityManagerInterface $em) {
        $this->repo = $repo;
        $this->em = $em;
    }
   
    /**
     * @Route("/admin/place", name="admin_place", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('place/index.html.twig', [
            'places' => $this->repo->findAll(),
        ]);
    }

    /**
     * @Route("/place/new", name="place_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $place = new Place();
        $form = $this->createForm(PlaceType::class, $place);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->em->persist($place);
            $this->em->flush();

            return $this->redirectToRoute('admin_place');
        }

        return $this->renderForm('place/new.html.twig', [
            'place' => $place,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/admin/place/{id}", name="place_show", methods={"GET"})
     */
    public function show(Place $place): Response
    {
        return $this->render('place/show.html.twig', [
            'place' => $place,
        ]);
    }

    /**
     * @Route("/admin/place/edit/{id}", name="place_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Place $place): Response
    {
        $form = $this->createForm(PlaceType::class, $place);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->flush();

            return $this->redirectToRoute('place_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('place/edit.html.twig', [
            'place' => $place,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/admin/place/delete/{id}", name="place_delete")
     */
    public function delete($id): Response
    {
            $place = $this->repo->find($id);
            $this->em->remove($place);
            $this->em->flush();

        return $this->redirectToRoute('admin_place');
    }
}
