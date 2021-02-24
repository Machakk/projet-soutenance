<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="user_profil")
     */
    public function index(): Response
    {
        $icon = $this->getParameter('photos_icon');
        $iconFb = $icon . "/fb.png";

        return $this->render('user_profil/profil.html.twig', [
            'controller_name' => 'UserProfilController',
        ]);

    }
}
