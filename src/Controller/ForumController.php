<?php

namespace App\Controller;

use App\Repository\PostForumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{
    /**
     * @Route("/forum", name="forum")
     */
    public function index(PostForumRepository $postForumRepository): Response
    {
        $posts = $postForumRepository->findAll();
        return $this->render('forum/forum.html.twig', [
            'posts' => $posts,
        ]);
    }
    /**
     * @Route("/forum/post", name="forum_post")
     */
    public function index2(PostForumRepository $postForumRepository): Response
    {
        $posts = $postForumRepository->findAll();
        return $this->render('forum/post.html.twig', [
            'posts' => $posts,
        ]);
    }
}
