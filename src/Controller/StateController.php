<?php

namespace App\Controller;

use App\Entity\State;
use App\Form\StateType;
use App\Repository\StateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class StateController extends AbstractController
{
    /**
     * @Route("/admin/state", name="state_index")
     */
    public function index(StateRepository $stateRepository): Response
    {
        $state = $stateRepository->findAll();

        return $this->render('state/index.html.twig', [
            'states' => $state,
        ]);
    }

    /**
     * @Route("/admin/state/new", name="state_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $state = new State();
        $form = $this->createForm(StateType::class, $state);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($state);
            $entityManager->flush();

            return $this->redirectToRoute('state_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('state/new.html.twig', [
            'state' => $state,
            'form' => $form,
        ]);
    }

    /**
     * @Route("admin/state/{id}", name="state_show", methods={"GET"})
     */
    public function show(State $state): Response
    {
        return $this->render('state/show.html.twig', [
            'state' => $state,
        ]);
    }

    /**
     * @Route("/admin/state/edit/{id}", name="state_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, State $state, EntityManagerInterface $em): Response
    {

        $form = $this->createForm(StateType::class, $state);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $em->flush();

            return $this->redirectToRoute('state_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('state/edit.html.twig', [
            'state' => $state,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/admin/delete/{id}", name="state_delete", methods={"POST"})
     */
    public function delete(Request $request, State $state): Response
    {
        if ($this->isCsrfTokenValid('delete' . $state->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($state);
            $entityManager->flush();
        }

        return $this->redirectToRoute('state_index', [], Response::HTTP_SEE_OTHER);
    }
}
