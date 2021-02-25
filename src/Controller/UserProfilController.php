<?php

namespace App\Controller;

use App\Repository\PostForumRepository;
use App\Repository\SkillsRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserProfilController extends AbstractController
{
    /**
     * @Route("/profil-{id}", name="user_profil")
     */
    public function index(UsersRepository $usersRepository, $id, PostForumRepository $postForumRepository, SkillsRepository $skillsRepository): Response
    {

        $user = $usersRepository->find($id);
        $posts = $postForumRepository->findAll();
        
        $icon = $this->getParameter('photos_icon');
        $iconFb = $icon . "/fb.png";
       
        // $user->getSkills();
        // var_dump($user);
        // die();
        // $skill = $skillsRepository->findAll();
        // $skills= $skillsRepository->findByUser($user);
        // var_dump($skills);
        // die();
        return $this->render('user_profil/profil.html.twig', [
            'user' => $user,
            'posts' => $posts
        ]);

    }
}
