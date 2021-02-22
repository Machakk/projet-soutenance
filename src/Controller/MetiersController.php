<?php

namespace App\Controller;

use App\Repository\MetiersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MetiersController extends AbstractController
{
    /**
     * @Route("/admin/metiers", name="admin_metiers")
     */
    public function index(MetiersRepository $metiersRepository): Response
    {
        $metiers = $metiersRepository->findAll();
        return $this->render('admin/metiers.html.twig', [
            'metiers' => $metiers,
        ]);
    }
}
