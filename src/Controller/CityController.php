<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\CitySearch;
use App\Form\CitySearchType;
use App\Form\CityType;
use App\Repository\CityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/city")
 */
class CityController extends AbstractController
{

    public function __construct(CityRepository $repo, EntityManagerInterface $em)
    {
        $this->repo = $repo;
        $this->em = $em;
    }
    /**
     * @Route("/", name="admin_city", methods={"GET"})
     */
    public function index(CityRepository $cityRepository, Request $request): Response
    {
        $search = new CitySearch();
        $city = $cityRepository->findAll();

        $form = $this->createForm(CitySearchType::class, $search);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData();
            $city = $cityRepository->getAllCities($search);
        }

        return $this->render('admin/city/index.html.twig', [
            'cities' => $city,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="city_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $city = new City();
        $form = $this->createForm(CityType::class, $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($city);
            $this->em->flush();

            return $this->redirectToRoute('admin_city');
        }

        return $this->renderForm('admin/city/new.html.twig', [
            'city' => $city,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/edit/{id}", name="city_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, City $city): Response
    {
        $form = $this->createForm(CityType::class, $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            return $this->redirectToRoute('admin_city');
        }

        return $this->renderForm('admin/city/edit.html.twig', [
            'city' => $city,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="city_delete", methods={"GET","POST"})
     */
    public function delete($id): Response
    {
        $city = $this->repo->find($id);
        $this->em->remove($city);
        $this->em->flush();
        return $this->redirectToRoute('admin_city');
    }
}
