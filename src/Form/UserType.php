<?php

namespace App\Form;

use App\Entity\Metiers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordStrength;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

        ->add('pseudo', TextType::class, [
            'required' => true,
            'attr' => [
                'class' => 'form-control mb-3'
            ]
            
        ])
        ->add('email',EmailType::class,[
            'required'=>true,
            'attr' => [
                'placeholder'=>'prenom.nom@domaine.com'
            ]
        ])

        ->add('roles', ChoiceType::class, [
            'required'=>false,
            'multiple' => true,
            'expanded' => true,
            'choices' => [
                    'super admin' => 'ROME_SUPER_ADMIN',
                    'admin' => 'ROLE_ADMIN',
                    'utiliseateur' => ' ROLE_USER'
            ]
        ])

        ->add('plainPassword', PasswordType::class, [
            'mapped' => false,
            'constraints' => [
                new PasswordStrength([
                    'minLength' => 8,
                    'tooShortMessage' => 'Le mot de passe doit contenir au moins 8 caractères',
                    'minStrength' => 4,
                    'message' => 'Le mot de passe doit contenir au moins une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial'
                ])
            ],
            'attr' => [
                'placeholder' => '••••••••'
            ],
            'label' => 'Mot de passe',
            'required' => false
        ])

        ->add('metier', EntityType::class, [
            'required' => true,
            'class' => Metiers::class,
            'choice_label' => 'metier',
            
        ])

        ->add('niveau', ChoiceType::class, [
            'required' => true,
            'choices' => [
                '- ton niveau -' => false,
                'Junior' => 'Junior',
                'Confirmé' => 'Confirmé',
                'Expert' => 'Expert'
            ],
            'attr' => [
                'class' => 'form-control mb-3'
            ]
        ])

        

        ->add('valider',SubmitType::class)

        
        ;

        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
