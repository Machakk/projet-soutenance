<?php

namespace App\Controller;

use App\Repository\PostForumRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ForumController extends AbstractController
{
    /**
     * @Route("/forum", name="forum")
     * 
     */
    public function index(PostForumRepository $postForumRepository): Response
    {
        $posts = $postForumRepository->findAll();
        return $this->render('forum/forum.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/back", name="forumBack")
     * 
     */
    public function forumBack(PostForumRepository $postForumRepository): Response
    {
        $posts = $postForumRepository->findAll();
        return $this->render('forum/forumBack.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/forum/design", name="forumDesign")
     * 
     */
    public function forumDes(PostForumRepository $postForumRepository): Response
    {
        $posts = $postForumRepository->findAll();
        return $this->render('forum/forumDesign.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/forum/front", name="forumFront")
     * 
     */
    public function forumFront(PostForumRepository $postForumRepository): Response
    {
        $posts = $postForumRepository->findAll();
        return $this->render('forum/forumFront.html.twig', [
            'posts' => $posts,
        ]);
    }

    // /**
    //  * @Route("/forum/post-{id}", name="forum_post")
    //  */
    // public function post(PostForumRepository $postForumRepository, Request $request, $id): Response
    // {
    //     $post = $postForumRepository->find($id);
    //     $form = $this->createForm(PostType::class, $post);
    //     $form->handleRequest($request);
    //     if($form->isSubmitted() && $form->isValid())
    //     {
    //         $manager = $this->getDoctrine()->getManager();
    //         $manager->persist($post);
    //         $manager->flush();
    //         return $this->redirectToRoute('forum_post');
    //     }
    //     return $this->render('forum/post.html.twig', [
    //         'postForum' => $form->createView()
    //     ]);
    // }


    /**
     * @Route("/forum/post-{id}", name="forum_post")
     */
    public function post(PostForumRepository $postForumRepository, $id): Response
    {
        $posts = $postForumRepository->find($id);

        /*
            - récupérer le login form
            - if submit et valid
                - vérif utilisateur mdp-login
                - si ok : return new RedirectResponse($request->headers->get('referer'));
            - générer le formulaire
        */
        
        return $this->render('forum/post.html.twig', [
            'posts' => $posts,
            // passer le formulaire à la vue
        ]);
    }
}
