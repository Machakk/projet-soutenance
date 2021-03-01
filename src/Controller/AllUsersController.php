<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AllUsersController extends AbstractController
{
    /**
     * @Route("/all-users", name="all_users")
     */
    public function index(UsersRepository $usersRepository): Response
    {
        $users = $usersRepository->findAll();
        return $this->render('all_users/all-users.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/all-users/front", name="usersFront")
     */
    public function usersFront(UsersRepository $usersRepository): Response
    {
        $users = $usersRepository->findAll();
        return $this->render('all_users/usersFront.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/all-users/back", name="usersBack")
     */
    public function usersBack(UsersRepository $usersRepository): Response
    {
        $users = $usersRepository->findAll();
        return $this->render('all_users/usersBack.html.twig', [
            'users' => $users
        ]);
    }


    /**
     * @Route("/all-users/design", name="usersDesign")
     */
    public function usersDesign(UsersRepository $usersRepository): Response
    {
        $users = $usersRepository->findAll();
        return $this->render('all_users/usersDesign.html.twig', [
            'users' => $users
        ]);
    }


    /**
     * @Route("/all-users/fullstack", name="usresFullstack")
     */
    public function usresFullstack(UsersRepository $usersRepository): Response
    {
        $users = $usersRepository->findAll();
        return $this->render('all_users/usersFullstack.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/all-users/autre", name="usersAutre")
     */
    public function usersAutre(UsersRepository $usersRepository): Response
    {
        $users = $usersRepository->findAll();
        return $this->render('all_users/usersAutre.html.twig', [
            'users' => $users
        ]);
    }


}
