<?php

namespace App\Controller;

use App\Entity\Metiers;
use App\Entity\Users;
use App\Form\RegistrationFormType;
use App\Repository\MetiersRepository;
use App\Security\AppAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, AppAuthenticator $authenticator, MetiersRepository $metiersRepository): Response
    {
        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if($form->isValid()) {
                // encode the plain password
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
                
                $infoImg = $form['imgprofil']->getData();
                $infoMetier = $form['metier']->getData();
                // var_dump($infoMetier->getMetier());
                // die();
                if($infoImg!=null){
                    
                    $extebsionImg = $infoImg->guessExtension();
                    $nomImg = 'user-'. time() .'.'. $extebsionImg;// compose un nom d'image unique
                    $infoImg->move($this->getParameter('photos_users') ,$nomImg); //déplace l'image dans le dossier
                    
                    $user->setImgprofil($nomImg);
                } 
                else {
                    if($infoMetier->getMetier()=="Backend"){
                        $nomImg="back-end.png";
                        $user->setImgprofil($nomImg);
                    }
                    else if($infoMetier->getMetier()=="Frontend"){
                        $nomImg="front-end.png";
                        $user->setImgprofil($nomImg);
                    }
                    else if($infoMetier->getMetier()=="Design"){
                        $nomImg="design.png";
                        $user->setImgprofil($nomImg);
                    }
                }
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                // do anything else you need here, like send an email
    
                return $guardHandler->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $authenticator,
                    'main' // firewall name in security.yaml
                );
            } 
            else
            {
            //     $errors = array();
            //     foreach ($form->getErrors() as $error)
            //     {
            //         $errors[] = $error->getMessage();
            //     }
            //     var_dump($errors);
            // die();
            }
        } else {
            
            

        }
        

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
