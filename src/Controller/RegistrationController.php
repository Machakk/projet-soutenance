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
   
                /* vérifier que tous les champs obligatoire sont remplis*/
                if($form['pseudo']->getData()!=null && 
                    $form['email']->getData()!=null &&
                    $form['agreeTerms']->getData()!=null && 
                    $form['plainPassword']->getData()!=null && 
                    $form['metier']->getData()!=null && 
                    $form['niveau']->getData()!=null)
                {
                    /**password  */
                    $user->setPassword(
                        $passwordEncoder->encodePassword(
                            $user,
                            $form->get('plainPassword')->getData()
                        )
                    );
                    
                    $infoImg = $form['imgprofil']->getData();
                    $infoMetier = $form['metier']->getData();
                

                    /** Image de profil entrée par le user */
                    if($infoImg!=null){
                        
                        $extebsionImg = $infoImg->guessExtension();
                        
                        /* vérifier le type de image */
                        if($extebsionImg =='png' || $extebsionImg =='jpeg' || $extebsionImg =='jpg' || $extebsionImg =='gif') {

                            $nomImg = 'user-'. time() .'.'. $extebsionImg;// compose un nom d'image unique
                            $infoImg->move($this->getParameter('photos_users') ,$nomImg); //déplace l'image dans le dossier
                            
                            $user->setImgprofil($nomImg);
                        } 
                        else {
                            $this->addFlash('danger', 'Pas le bon type d\'image !');
                            return $this->render('registration/register.html.twig', [
                                'registrationForm' => $form->createView(),
                            ]);
                        }

                    } 

                    /** Image de profil par défaut */
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
                        else {
                            $nomImg="unknow.png";
                            $user->setImgprofil($nomImg);
                        }
                    }
                    
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($user);
                    $entityManager->flush();
                    
                    return $guardHandler->authenticateUserAndHandleSuccess(
                        $user,
                        $request,
                        $authenticator,
                        'main' // firewall name in security.yaml
                    );
                }
                else {
                    $this->addFlash('danger', 'Vous devez remplir tous les champs!');
                }
            } 
           
        } 
        

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
