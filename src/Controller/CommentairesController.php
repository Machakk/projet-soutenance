<?php

namespace App\Controller;

use App\Repository\CommentaireForumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
