<?php

namespace App\Controller;

use App\Entity\Metiers;
use App\Repository\MetiersRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    /**
     * @Route("/admin/metiers", name="create_metiers")
     */
    public function createMetier(Request $request)
    {
        $metiers = new Metiers();
        $form = $this->createForm(MetiersType::class, $maison);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($metiers);
            $manager->flush();
            // metier ajouté
        }
        else
        {
            //error
        }
        return $this->redirectToRoute('admin_metiers');
    }

    /**
     * @Route("/admin/metiers-{id}", name="update_metiers")
     */
    public function updateMetiers(Request $request, $id, MetiersRepository $metiersRepository)
    {
        $metiers = $metiersRepository->find($id);
        $form = $this->createForm(MetiersType::class, $maison);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($maison);
            $manager->flush();
            return $this->redirectToRoute('admin_metiers');
            //métier modifié
        }
        
    }

    /**
     * @Route("/admin/metiers-{id}", name="delete_metiers")
     */
    public function deleteMetiers($id, MetiersRepository $metiersRepository)
    {
        $metiers = $metiersRepository->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($maison);
        $manager->flush();
        return $this->redirectToRoute('admin_metiers');
    }

}
