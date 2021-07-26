<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{


    /**
     * @Route("/", name="home_")
     */
    public function index(UserRepository $repo): Response
    {
        $user = $repo->findAll();
        return $this->render('home/home.html.twig', [
            'user' => $user
        ]);
    }
}
