<?php

namespace App\Controller;

use App\Repository\PostForumRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\PostsType;

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
     * @Route("/forum/post-{id}", name="forum_post")
     */
    public function post(PostForumRepository $postForumRepository, $id, Request $request): Response
    {
        $posts = $postForumRepository->find($id);
        $form = $this->createForm(PostsType::class, $posts);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($posts);
            $manager->flush();
            
            $referer = $request->headers->get('referer');
            return new RedirectResponse($referer);
        }
        return $this->render('forum/post.html.twig', [
            'posts' => $posts,
            // passer le formulaire à la vue
        ]);

        /*
            - récupérer le login form
            - if submit et valid
                - vérif utilisateur mdp-login
                - si ok : return new RedirectResponse($request->headers->get('referer'));
            - générer le formulaire
        */

        
        
    }
}
