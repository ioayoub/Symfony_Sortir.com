<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Form\CampusType;
use App\Entity\CampusSearch;
use App\Form\CampusSearchType;
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
     * @Route("/admin/campus", name="admin_campus")
     */
    public function index(Request $request, CampusRepository $campRepo): Response
    {
        $search = new CampusSearch();
        $campus = $this->repo->findAll();

        $form = $this->createForm(CampusSearchType::class, $search);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData();
            $campus = $this->repo->getAllCampus($search);
        }

        return $this->render('admin/campus/index.html.twig', [
            'campus' => $campus,
            'form' => $form->createView(),
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
