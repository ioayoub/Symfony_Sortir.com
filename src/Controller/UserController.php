<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\User;
use App\Form\UserRegisterType;
use App\Repository\CampusRepository;
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
    public function __construct(EntityManagerInterface $em, UserRepository $repo, CampusRepository $campusRepo)
    {
        $this->em = $em;
        $this->repo = $repo;
        $this->campusRepo = $campusRepo;
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
        $campus = $this->campusRepo->findAll();

        $form = $this->createForm(UserRegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $hasher = $hash->hashPassword($user, $user->getPassword());
            $user->setPassword($hasher);

            if ($user->getimageName() == null) {
                $user->setimageName("default.jpg");
                $user->setimageSize(0);
                $user->setUpdatedAt(new \DateTime());
            }

            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash('success', 'Vous ??tes d??sormais inscrit.');


            return $this->redirectToRoute('home_', [
                'user' => $user,
                'form' => $form->createView(),
                'campus' => $campus

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



        if ($id != $this->getUser()->getId() && !$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('home_');
        }

        $form = $this->createForm(UserRegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hasher = $hash->hashPassword($user, $user->getPassword());
            $user->setPassword($hasher);

            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash('success', 'Votre profil a ??t?? mis ?? jour.');

            return $this->redirectToRoute('home_', [
                'id' => $user->getId(),
                'user' => $user,
                'form' => $form->createView(),
            ]);
        }

        return $this->render('user/edit.html.twig', [
            'controller_name' => 'UserController',
            'form' => $form->createView(),
            'id' => $user->getId(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/user/delete/{id}", name="user_delete", methods={"GET", "POST"})
     */
    public function delete($id, Request $request): Response
    {
        $user = $this->repo->find($id);

        if ($id != $this->getUser()->getId() && !$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('home_');
        } elseif ($this->isCsrfTokenValid('delete' . $user->getid(), $request->get('_token'))) {

            $this->em->remove($user);
            $this->em->flush();
            $this->addFlash('success', 'Votre profil a ??t?? supprim??.');
        }

        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin_user');
        } else {
            return $this->redirectToRoute('home_');
        }
    }

    /**
     * @Route("/user/{id}", name="user_show")
     */

    public function show(int $id)
    {
        $user = $this->repo->find($id);

        if (!$user) {
            return $this->render('errors/userNotFound.html.twig');
        }

        dump($user);

        return $this->render('user/show.html.twig', [
            'id' => $id,
            'user' => $user
        ]);
    }
}
