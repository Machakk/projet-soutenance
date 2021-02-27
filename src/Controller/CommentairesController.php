<?php

namespace App\Controller;

use App\Form\PostsType;
use App\Entity\CommentaireForum;
use App\Form\CommentairesPostType;
use App\Repository\UsersRepository;
use App\Form\CommentairePostUserType;
use App\Repository\PostForumRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CommentaireForumRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentairesController extends AbstractController
{
    /**
     * @Route("/admin/commentaires", name="admin_commentaires")
     */
    public function index(CommentaireForumRepository $commentaireForumRepository): Response
    {
        $commentaires = $commentaireForumRepository->findAll();
        return $this->render('admin/commentaires.html.twig', [
            'commentaires' => $commentaires,
        ]);
    }

    /**
     * @Route("/admin/commentaires/create", name="commentaire_create")
     */
    public function createCommentaire(Request $request){

        $user = $this->getUser();
        $commentaire = new CommentaireForum();
        $form = $this->createForm(CommentairesPostType::class, $commentaire);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $date = new \DateTime('@'.strtotime('now'));
            $commentaire->setDate($date);
            $commentaire->setUser($user);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($commentaire);
            $manager->flush();
            return $this->redirectToRoute('admin_commentaires');
        }

        return $this->render('admin/commentaireForm.html.twig', [
            'commentaireForm'=>$form->createView(),
        ]);
    }

    /**
     * @Route("/admin/commentaires/update-{id}", name="commentaire_update")
     */
    public function updateCommentaires(CommentaireForumRepository $commentaireForumRepository, $id, Request $request)
    {
        $commentaire = $commentaireForumRepository->find($id);
        $form = $this->createForm(CommentairesPostType::class, $commentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($commentaire);
            $manager->flush();
            $this->addFlash('success', 'La commentaire a été modifiée');
            return $this->redirectToRoute('admin_commentaires');
        }
        return $this->render('admin/commentaireForm.html.twig', [
            'commentaireForm' => $form->createView()
        ]);
    }


    

    /**
     * @Route("/admin/commentaires/delete-{id}", name="commentaire_delete")
     */
    public function deletePosts(CommentaireForumRepository $commentaireForumRepository, $id) {
        $commentaire = $commentaireForumRepository->find($id);
        
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($commentaire);
        $manager->flush();
     
        return $this->redirectToRoute('admin_commentaires');
    }

    /* test 1 */

    // /**
    //  * @Route("/forum/post-{id}", name="commentaire_user_create")
    //  */
    // public function createCommentaireUser(Request $request){

    //     $user = $this->getUser();
    //     $commentaire = new CommentaireForum();
    //     $form = $this->createForm(CommentairePostUserType::class, $commentaire);
    //     $form->handleRequest($request);

    //     if($form->isSubmitted() && $form->isValid())
    //     {
    //         $commentaire->setUser($user);
    //         $date = new \DateTime('@'.strtotime('now'));
    //         $commentaire->setDate($date);
    //         $manager = $this->getDoctrine()->getManager();
    //         $manager->persist($commentaire);
    //         $manager->flush();
    //         return $this->redirectToRoute('commentaire_user_create');
    //     }

    //     return $this->render('forum/post.html.twig', [
    //         'commentaireUserCreate'=>$form->createView(),
    //     ]);
    // }
    

    /* test 2 */

    /**
     * @Route("/forum/post-{id}", name="commentaire_user_create")
     */
    public function createCommentaireUser(Request $request, PostForumRepository $postForumRepository, CommentaireForumRepository $commentaireForumRepository, UsersRepository $usersRepository, $id){

        $user = $this->getUser();
        $commentaire = new CommentaireForum();
        $form = $this->createForm(CommentairePostUserType::class, $commentaire);
        $form->handleRequest($request);
        $post = $postForumRepository->find($id);
        
        
        if($form->isSubmitted() && $form->isValid())
        {
            $commentaire->setUser($user);
            $commentaire->setPost($post);
            $date = new \DateTime('@'.strtotime('now'));
            $commentaire->setDate($date);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($commentaire);
            $manager->flush();

            $this->addFlash('success', 'Vous avez commenté ce post!');
        }
        else
        {
            $this->addFlash('danger', 'Un problème est survenu lors de création de commentaire!');
        }
        
        $commentaires = $commentaireForumRepository->findAll();
        
        return $this->render('forum/post.html.twig', [
            'id' => $id,
            'commentaireUserCreate'=>$form->createView(),
            'post'=> $post,
            'commentaires' => $commentaires
        ]);
    }


    /* test 3 */

    // /**
    //  * @Route("/forum/post-{id}", name="commentaire_user_create")
    //  * @Route("/forum/post-{id}", name="forum_post")
    //  */
    // public function createCommentaireUser(Request $request, PostForumRepository $postForumRepository, $id)
    // {

    //     $user = $this->getUser();
    //     $commentaire = new CommentaireForum();
    //     $form = $this->createForm(CommentairePostUserType::class, $commentaire);
    //     $form->handleRequest($request);
    //     $post = $postForumRepository->find($id);

    //     $posts = $postForumRepository->find($id);
    //     $form2 = $this->createForm(PostsType::class, $posts);
    //     $form2->handleRequest($request);

    //     if($form->isSubmitted() && $form->isValid() && $form2->isSubmitted() && $form2->isValid())
    //     {
    //         $commentaire->setUser($user);
    //         $commentaire->setPost($post);

    //         $date = new \DateTime('@'.strtotime('now'));
    //         $commentaire->setDate($date);
    //         $manager = $this->getDoctrine()->getManager();
    //         $manager->persist($commentaire);
    //         $manager->flush();

            
    //         $manager2 = $this->getDoctrine()->getManager();
    //         $manager2->persist($posts);
    //         $manager2->flush();

    //         return $this->redirectToRoute('commentaire_user_create', ['id' => $id]);
    //     }

    //     return $this->render('forum/post.html.twig', [
    //         'commentaireUserCreate'=>$form->createView(),
    //         'posts' => $posts,
    //     ]);
    // }
}
