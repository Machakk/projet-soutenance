<?php

namespace App\Controller;

use App\Repository\CommentaireForumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentairesController extends AbstractController
{
    /**
     * @Route("/commentaires", name="commentaires")
     */
    public function index(CommentaireForumRepository $commentaireForumRepository): Response
    {
        $commentaires = $commentaireForumRepository->findAll();
        return $this->render('commentaires/index.html.twig', [
            'commentaires' => $commentaires,
        ]);
    }
}
