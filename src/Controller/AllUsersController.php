<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AllUsersController extends AbstractController
{
    /**
     * @Route("/all-users", name="all_users")
     */
    public function index(): Response
    {
        return $this->render('all_users/all-users.html.twig', [
            'controller_name' => 'AllUsersController',
        ]);
    }
}
