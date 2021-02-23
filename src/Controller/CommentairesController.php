<?php

namespace App\Controller;

use App\Entity\CommentaireForum;
use App\Form\CommentairesPostType;
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
    public function createPost(Request $request){
        $commentaire = new CommentaireForum();
        $form = $this->createForm(CommentairesPostType::class, $commentaire);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($commentaire);
            $manager->flush();
            return $this->redirectToRoute('admin_commentaires');
        }

        return $this->render('admin/commentaireForm.html.twig', [
            'commentaireForm'=>$form->createView(),
        ]);
    }
}
