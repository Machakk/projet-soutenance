<?php

namespace App\Controller;

use App\Form\PostsType;
use App\Entity\PostForum;
use App\Entity\CommentaireForum;
use App\Form\CommentairePostUserType;
use App\Repository\PostForumRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
     * @Route("/forum/back", name="forumBack")
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

    /**
     * @Route("/forum/create", name="post_createu")
     */
    public function createPostu(Request $request){
        // $user = new Users();
        
        // $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        
        $post = new PostForum();
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid()) {

                
                $infoImg = $form['img']->getData();
                if($infoImg !=null){

                    $extebsionImg = $infoImg->guessExtension();
                    $nomImg = '1-'. time() .'.'. $extebsionImg;// compose un nom d'image unique
                    $infoImg->move($this->getParameter('photos_posts') ,$nomImg); //déplace l'image dans le dossier
        
                    $post->setImg($nomImg);
                }
                $date = new \DateTime('@'.strtotime('now'));
                $post->setDate($date);
                $post->setUser($user);

               
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($post);
                $manager->flush();
                return $this->redirectToRoute('forum');
            } 
            else {
                
            }
        
        } 
        else {
            // echo "hi";
            // die();
        }
        return $this->render('forum/postForm.html.twig', [
            'postForm'=>$form->createView(),
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


    // /**
    //  * @Route("/forum/post-{id}", name="forum_post")
    //  * @Route("/forum/post-", name="forum_post2")
    //  */
    // public function post(PostForumRepository $postForumRepository, $id, Request $request): Response
    // {
    //     $posts = $postForumRepository->find($id);
    //     $form = $this->createForm(PostsType::class, $posts);
    //     $form->handleRequest($request);
    //     if($form->isSubmitted() && $form->isValid())
    //     {
    //         $user->setPassword(
    //             $passwordEncoder->encodePassword(
    //                 $user,
    //                 $form->get('plainPassword')->getData()
    //             )
    //         );
    //         $manager = $this->getDoctrine()->getManager();
    //         $manager->persist($posts);
    //         $manager->flush();
            
    //         $referer = $request->headers->get('referer');
    //         return new RedirectResponse($referer);
    //     }
    //     return $this->render('forum/post.html.twig', [
    //         'posts' => $posts,
    //         // passer le formulaire à la vue
    //     ]);

    //     /*
    //         - récupérer le login form
    //         - if submit et valid
    //             - vérif utilisateur mdp-login
    //             - si ok : return new RedirectResponse($request->headers->get('referer'));
    //         - générer le formulaire
    //     */       
        
    // }

    /**
     * 
     * @Route("/forum/post-{id}", name="forum_post")
     * @Route("/forum/post-", name="forum_post2")
     * 
     */
    public function createCommentaireUser(Request $request, PostForumRepository $postForumRepository, $id){

        $user = $this->getUser();
        $commentaire = new CommentaireForum();
        $form = $this->createForm(CommentairePostUserType::class, $commentaire);
        $form->handleRequest($request);
        $post = $postForumRepository->find($id);

        $posts = $postForumRepository->find($id);
        $form2 = $this->createForm(PostsType::class, $posts);
        $form2->handleRequest($request);

        
        if($form->isSubmitted() && $form->isValid() && $form2->isSubmitted() && $form2->isValid())
        {
            $commentaire->setUser($user);
            $commentaire->setPost($post);

            $date = new \DateTime('@'.strtotime('now'));
            $commentaire->setDate($date);

            
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($commentaire);
            $manager->flush();

            
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($posts);
            $manager->flush();
            

            return $this->redirectToRoute('forum_post',['id' => $id]);
        }

        return $this->render('forum/post.html.twig', [
            'posts' => $posts,
            'commentaireUserCreate'=>$form->createView(),
            
            
        ]);

        
    }
}
