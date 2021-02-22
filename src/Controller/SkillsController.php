<?php

namespace App\Controller;

use App\Repository\SkillsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
