<?php

namespace App\Controller;

use App\Repository\PostForumRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserProfilController extends AbstractController
{
    /**
     * @Route("/profil-{id}", name="user_profil")
     */
    public function index(UsersRepository $usersRepository, $id, PostForumRepository $postForumRepository): Response
    {

        $user = $usersRepository->find($id);
        // $posts = $user->getPostForums();
        $posts = $postForumRepository->findAll();
        
        $icon = $this->getParameter('photos_icon');
        $iconFb = $icon . "/fb.png";
        // var_dump($posts);
        // die();

        // $id = 
        return $this->render('user_profil/profil.html.twig', [
            'user' => $user,
            'posts' => $posts
        ]);

    }
}
