<?php

namespace App\Controller;

use App\Form\ProfilUserType;
use App\Repository\PostForumRepository;
use App\Repository\SkillsRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserProfilController extends AbstractController
{
    /**
     * @Route("/profil-{id}", name="user_profil")
     */
    public function index(UsersRepository $usersRepository, $id, PostForumRepository $postForumRepository, SkillsRepository $skillsRepository): Response
    {

        $user = $usersRepository->find($id);
        $posts = $postForumRepository->findAll();
        
        $icon = $this->getParameter('photos_icon');
        $iconFb = $icon . "/fb.png";
        return $this->render('user_profil/profil.html.twig', [
            'user' => $user,
            'posts' => $posts
        ]);

    }

    /**
     * @Route("/profil/updateprofil-{id}", name="update_profil")
     */
    public function updateProfil(UsersRepository $usersRepository, $id, Request $request, UserPasswordEncoderInterface $passwordEncoder){
        $user = $usersRepository->find($id);
        $form = $this->createForm(ProfilUserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            if($form->get('plainPassword')->getData() !== null) 
            {
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
            }

            // image profil
            $oldNomImg1 = $user->getImgprofil();
    
            $oldCheminImg1 = $this->getParameter('photos_users') . '/' . $oldNomImg1;       
            if (file_exists($oldCheminImg1)) 
            {
                unlink($oldCheminImg1);
            }
            $infoImg1 = $form['imgprofil']->getData();
            $extensionImg1 = $infoImg1->guessExtension();
            $nomImg1 = '1-' . time() . '.' . $extensionImg1;
            $infoImg1->move($this->getParameter('photos_users'), $nomImg1);
            $user->setImgprofil($nomImg1);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            // redirection vers profil user courant 
            return $this->redirectToRoute('user_profil', ['id' => $id]);
        }
        return $this->render('user_profil/userProfilForm.html.twig', [
            'userProfilForm' => $form->createView()
        ]);
    }
}
