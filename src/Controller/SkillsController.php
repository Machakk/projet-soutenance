<?php

namespace App\Controller;

use App\Entity\Skills;
use App\Entity\Metiers;
use App\Form\SkillsType;
use App\Form\MetiersType;
use App\Repository\SkillsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SkillsController extends AbstractController
{
    /**
     * @Route("/admin/skills", name="admin_skills")
     */
    public function index(SkillsRepository $skillsRepository): Response
    {
        $skills=$skillsRepository->findAll();
        return $this->render('admin/skills.html.twig', [
            'skills' => $skills,
        ]);
    }

    /**
     * @Route("/admin/skills/create", name="skill_create")
     */
     public function createSkill(Request $request){

        $skill = new Skills();
        $form = $this->createForm(SkillsType::class, $skill);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            // Image
            $infoImg = $form['imageskill']->getData();
            $extebsionImg = $infoImg->guessExtension();
            $nomImg = '1-'. time() .'.'. $extebsionImg;// compose un nom d'image unique
            $infoImg->move($this->getParameter('photos_skills') ,$nomImg); //déplace l'image dans le dossier
 
            $skill->setImageskill($nomImg);

                $manager=$this->getDoctrine()->getManager();
                $manager->persist($skill);
                $manager->flush();
                return $this->redirectToRoute('admin_skills');
        }

        return $this->render('admin/skillsForm.html.twig', [
            'skillsForm'=>$form->createView(),
        ]);
    }



    /**
     * @Route("/admin/skills/update-{id}", name="skills_update")
     */
    public function updateSkills(SkillsRepository $skillsRepository, $id, Request $request)
    {
        $skills = $skillsRepository->find($id);
        $form = $this->createForm(SkillsType::class, $skills);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $oldNomImg1 = $skills->getImageskill();
    
            $oldCheminImg1 = $this->getParameter('photos_skills') . '/' . $oldNomImg1;       
            if (file_exists($oldCheminImg1)) 
            {
                unlink($oldCheminImg1);
            }
            $infoImg1 = $form['imageskill']->getData();
            $extensionImg1 = $infoImg1->guessExtension();
            $nomImg1 = '1-' . time() . '.' . $extensionImg1;
            $infoImg1->move($this->getParameter('photos_skills'), $nomImg1);
            $skills->setImageskill($nomImg1);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($skills);
            $manager->flush();
            $this->addFlash('success', 'La compètence a été modifiée');
            return $this->redirectToRoute('admin_skills');
        }
        return $this->render('admin/skillsForm.html.twig', [
            'skillsForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/skills/delete-{id}", name="skills_delete")
     */
    public function deleteSkills(SkillsRepository $skillsRepository, $id) {
        $skills = $skillsRepository->find($id);
        $oldNomImg1 = $skills->getImageskill();
        $oldCheminImg1 = $this->getParameter('photos_skills') . '/' . $oldNomImg1;
        if ($oldNomImg1 != null) {
            unlink($oldCheminImg1);
        }
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($skills);
        $manager->flush();
        $this->addFlash(
            'success', 'la maison a bien été supprimé'
        );
        return $this->redirectToRoute('admin_skills');
    }

}


