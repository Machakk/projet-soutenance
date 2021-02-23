<?php

namespace App\Controller;

use App\Entity\Skills;
use App\Form\SkillsType;
use App\Repository\SkillsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

}
