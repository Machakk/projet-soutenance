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
        $posts = $postForumRepository->findPosts();
        $skills= $user->getSkills();

        
        $icon = $this->getParameter('photos_icon');
        $iconFb = $icon . "/fb.png";
        return $this->render('user_profil/profil.html.twig', [
            'user' => $user,
            'posts' => $posts,
            'skills' => $skills
        ]);

    }

    /**
     * @Route("/profil/updateprofil-{id}", name="update_profil")
     */
    public function updateProfil(UsersRepository $usersRepository, $id, Request $request, UserPasswordEncoderInterface $passwordEncoder, SkillsRepository $skillsRepository ){
        $user = $usersRepository->find($id);
        $userlogin = $this->getUser();

        if($userlogin == $user){

            $form = $this->createForm(ProfilUserType::class, $user);
            $form->handleRequest($request);
    
            if($form->isSubmitted() && $form->isValid())
            {
                if( 
                $form['metier']->getData()!=null && 
                $form['pseudo']->getData()!=null &&
                $form['niveau']->getData()!=null)
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
        
                    $infoImg1 = $form['imgprofil']->getData();
                    $oldNomImg1 = $user->getImgprofil();
        
                    if($infoImg1!=null){
                        $oldCheminImg1 = $this->getParameter('photos_users') . '/' . $oldNomImg1;       
                        if (file_exists($oldCheminImg1)) 
                        {
                            unlink($oldCheminImg1);
                        }
                        $extensionImg = $infoImg1->guessExtension();
                        if($extensionImg =='png' || $extensionImg =='jpeg' || $extensionImg =='jpg' || $extensionImg =='gif') {
                            
                            $nomImg1 = '1-' . time() . '.' . $extensionImg;
                            $infoImg1->move($this->getParameter('photos_users'), $nomImg1);
                            $user->setImgprofil($nomImg1);
                        }
                        else {
                            $this->addFlash('danger', 'Pas le bon type d\'image !');
                            return $this->render('user_profil/userProfilForm.html.twig', [
                                'userProfilForm' => $form->createView()
                            ]);
                        }
                    }

                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($user);
                    $manager->flush();
                    $this->addFlash('success', 'Vous avez modifié votre profil!');
                    // redirection vers profil user courant 
                    return $this->redirectToRoute('user_profil', ['id' => $id]);
                }
                else {
                    $this->addFlash('danger', 'Vous devez remplir les champs suivants: pseudo, métier, niveau !');
                }
            }
            return $this->render('user_profil/userProfilForm.html.twig', [
                'userProfilForm' => $form->createView()
            ]);
        }
        else {
            return $this->render('home/home.html.twig');
        }
    }
}