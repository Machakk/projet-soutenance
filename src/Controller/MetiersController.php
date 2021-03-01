<?php

namespace App\Controller;

use App\Entity\Metiers;
use App\Form\MetiersType;
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
     * @Route("/admin/metiers/create", name="create_metiers")
     */
    public function createMetier(Request $request)
    {
        
        $metiers = new Metiers();
        $form = $this->createForm(MetiersType::class, $metiers);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            if(!is_null($form['metier']))
            {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($metiers);
                $manager->flush();
                $this->addFlash('success', 'Vous avez ajouté un nouveau métier!');
                // metier ajouté
                return $this->redirectToRoute('admin_metiers');
            }
        }
        else
        {
            //error
        }

        return $this->render('admin/metiersForm.html.twig', [
            'metiersForm'=>$form->createView(),
        ]);
       
    }

    /**
     * @Route("/admin/metiers/update-{id}", name="update_metiers")
     */
    public function updateMetiers(Request $request, $id, MetiersRepository $metiersRepository)
    {
        $metiers = $metiersRepository->find($id);
        $form = $this->createForm(MetiersType::class, $metiers);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($metiers);
            $manager->flush();
            return $this->redirectToRoute('admin_metiers');
            $this->addFlash('success', 'Modification réussie!');
            //métier modifié
        }
        return $this->render('admin/metiersForm.html.twig', [
            'metiersForm'=>$form->createView(),
        ]);
        
    }

    /**
     * @Route("/admin/metiers/delete-{id}", name="delete_metiers")
     */
    public function deleteMetiers($id, MetiersRepository $metiersRepository)
    {
        $metiers = $metiersRepository->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($metiers);
        $manager->flush();
        return $this->redirectToRoute('admin_metiers');
    }

}
