<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Nom Prenom'
                ]
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Votre adresse mail'
                ]
            ] )
            ->add('objet', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Sujet'
                ]
            ])
            ->add('message', TextareaType::class , [
                'required' => true,
                'attr' => [
                    'cols' => 30,
                    'rows' => 5,
                    'minlength' => 1, //please fill this field
                    'maxlength' => 5000 ,
                    'placeholder' => 'Votre Message'
                ],
                'help' => ' maximum 1000 caractères'
            ])
            ->add("envoyer", SubmitType::class, [
                'attr' => [
                    'class' => 'btn-valide-post w-100 '
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
