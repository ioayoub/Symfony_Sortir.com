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
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    public function __construct(EntityManagerInterface $em, UserRepository $repo)
    {
        $this->em = $em;
        $this->repo = $repo;
    }

    /**
     * @Route("/user", name="user_index")
     */
    public function index(): Response
    {
        $user = $this->repo->findAll();


        return $this->render('home/home.html.twig', [
            'controller_name' => 'AdminPropertyController',
            'user' => $user
        ]);
    }


    /**
     * @Route("/register", name="user_register")
     */
    public function register(Request $request, UserPasswordHasherInterface $hash): Response
    {
        $user = new User();

        $form = $this->createForm(UserRegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hasher = $hash->hashPassword($user, $user->getPassword());
            $user->setPassword($hasher);

            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash('success', 'Vous êtes désormais inscrit.');


            return $this->redirectToRoute('home_', [
                'user' => $user,
                'form' => $form->createView()

            ]);
        }


        return $this->render('user/register.html.twig', [
            'controller_name' => 'UserController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/edit/{id}", name="user_edit", methods={"GET", "POST"})
     */
    public function edit($id, Request $request, UserPasswordHasherInterface $hash): Response
    {

        $user = $this->repo->find($id);

        if ($id != $this->getUser()->getId()) {
            return $this->redirectToRoute('home_');
        }

        $form = $this->createForm(UserRegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hasher = $hash->hashPassword($user, $user->getPassword());
            $user->setPassword($hasher);

            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash('success', 'Votre profil a été mis à jour.');

            return $this->redirectToRoute('home_', [
                'id' => $user->getId(),
                'user' => $user,
                'form' => $form->createView(),



            ]);
        }

        return $this->render('user/register.html.twig', [
            'controller_name' => 'UserController',
            'form' => $form->createView(),
            'id' => $user->getId()
        ]);
    }
}
