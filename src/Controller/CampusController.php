<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Form\CampusType;
use App\Repository\CampusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CampusController extends AbstractController
{

    public function __construct(EntityManagerInterface $em, CampusRepository $repo)
    {
        $this->em = $em;
        $this->repo = $repo;
    }
    /**
     * @Route("/admin/campus", name="campus_index")
     */
    public function index(): Response
    {
        $campus = $this->repo->findAll();
        return $this->render('admin/campus/index.html.twig', [
            'campus' => $campus
        ]);
    }

    /**
     * @Route("/admin/campus/create", name="campus_create")
     */

    public function create(Request $request)
    {
        $campus = new Campus();

        $form = $this->createForm(CampusType::class, $campus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($campus);
            $this->em->flush();

            return $this->redirectToRoute('campus_index', [
                'form' => $form->createView(),
                'campus' => $campus,
            ]);
        }
        return $this->render('admin/campus/create.html.twig', [
            'form' => $form->createView(),
            'campus' => $campus
        ]);
    }

    /**
     * @Route("/admin/campus/edit/{id}", name="campus_edit")
     */

    public function edit(int $id, Request $request)
    {
        $campus = $this->repo->find($id);

        $form = $this->createForm(CampusType::class, $campus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($campus);
            $this->em->flush();
            return $this->redirectToRoute('campus_index', [
                'form' => $form->createView(),
                'campus' => $campus,
            ]);
        }
        return $this->render('admin/campus/create.html.twig', [
            'form' => $form->createView(),
            'campus' => $campus,
            'id' => $id
        ]);
    }

    /**
     * @Route("/admin/campus/delete/{id}", name="campus_delete")
     * 
     */
    public function delete(int $id)
    {
        $campus = $this->repo->find($id);
        $this->em->remove($campus);
        $this->em->flush();
        return $this->redirectToRoute('campus_index');
    }
}