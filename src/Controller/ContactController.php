<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer): Response
    {
        $contactForm = $this->createForm(ContactType::class);
        $contactForm->handleRequest($request);
        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            if($contactForm['pseudo']->getData()!=null && 
                $contactForm['email']->getData()!=null &&
                $contactForm['objet']->getData()!=null &&
                $contactForm['message']->getData()!=null
                )
            {

                $contact = $contactForm->getData();
                $mail = (new \Swift_Message('DEV-NATION - Contact'))
                    ->setFrom($contact['email'])
                    ->setTo('sawsan.alkebsi@gmail.com')
                    ->setBody(
                        $this->renderView(
                            'contact/contentEmail.html.twig', [
                                'pseudo' => $contact['pseudo'],
                                'email' => $contact['email'],
                                'objet' => $contact['objet'],
                                'message' => $contact['message'],
                            ],
                            
                        ),
                        'text/html'
                    )
                ;
                $mailer->send($mail);
                $this->addFlash(
                    'success',
                    'Votre message a bien été envoyé'
                );
                return $this->redirectToRoute('contact');
            }
            else {
                $this->addFlash(
                    'danger',
                    'Vous dezvez remplir tous les champs!'
                );
            }
        }

        return $this->render('contact/contact.html.twig', [
            'contactForm' => $contactForm->createView(),
        ]);
    }
}
