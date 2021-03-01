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
            if(!is_null($form['content']) && !is_null($form['post']))
            {
                $date = new \DateTime('@'.strtotime('now'));
                $commentaire->setDate($date);
                $commentaire->setUser($user);
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($commentaire);
                $manager->flush();
                $this->addFlash('success', 'Vous avez ajouté un commentaire');
                return $this->redirectToRoute('admin_commentaires');
            }
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

    /**
     * @Route("/forum/post-{id}", name="commentaire_user_create")
     */
    public function createCommentaireUser(Request $request, PostForumRepository $postForumRepository, CommentaireForumRepository $commentaireForumRepository, UsersRepository $usersRepository, $id)
    {

        $user = $this->getUser();
        $commentaire = new CommentaireForum();
        $form = $this->createForm(CommentairePostUserType::class, $commentaire);
        $form->handleRequest($request);
        $post = $postForumRepository->find($id);
        
        if($form->isSubmitted() && $form->isValid())
        {
            if(!is_null($form['content']))
            {
                $commentaire->setUser($user);
                $commentaire->setPost($post);
                $date = new \DateTime('@'.strtotime('now'));
                $commentaire->setDate($date);
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($commentaire);
                $manager->flush();
                $this->addFlash('success', 'Vous avez commenté ce post!');
                return $this->redirectToRoute('commentaire_user_create', array('id' => $id));
            }
        }
        $commentaires = $commentaireForumRepository->findCommentaire();
        
        
        return $this->render('forum/post.html.twig', [
            'id' => $id,
            'commentaireUserCreate'=>$form->createView(),
            'post'=> $post,
            'commentaires' => $commentaires
            ]);        
    }
}
