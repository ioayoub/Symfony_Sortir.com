<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegisterType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_index")
     */
    public function indexUsers(UserRepository $repo)
    {
        $users = $repo->findAll();
        return $this->render('admin/index.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/admin/users", name="admin_user")
     */
    public function index(UserRepository $repo, Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hash): Response
    {
        $users = $repo->findAll();
        $newUser = new User();

        $form = $this->createForm(UserRegisterType::class, $newUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hasher = $hash->hashPassword($newUser, $newUser->getPassword());
            $newUser->setPassword($hasher);

            $em->persist($newUser);
            $em->flush();

            $this->addFlash('success', 'L\'utilisateur a bien été crée.');
            return $this->redirectToRoute('admin_user', [
                'newUser' => $newUser,
                'form' => $form->createView(),
            ]);
        }

        return $this->render('admin/users/users.html.twig', [
            'controller_name' => 'AdminUserController',
            'users' => $users,
            'form' => $form->createView(),
        ]);
    }
}
