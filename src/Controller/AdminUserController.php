<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_user")
     */
    public function index(UserRepository $repo): Response
    {
        $users = $repo->findAll();
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminUserController',
            'users' => $users,
        ]);
    }
}
