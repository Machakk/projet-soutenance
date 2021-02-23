<?php

namespace App\Controller;

use App\Repository\PostForumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostsController extends AbstractController
{
    /**
     * @Route("/admin/posts", name="admin_posts")
     */
    public function index(PostForumRepository $postForumRepository): Response
    {
        $posts = $postForumRepository->findAll();
        return $this->render('admin/posts.html.twig', [
            'posts' => $posts,
        ]);
    }
}
