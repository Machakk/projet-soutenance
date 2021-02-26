<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\Metiers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordStrength;

class ProfilUserType extends AbstractType
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
                    'Junior' => 'junior',
                    'Confirmé' => 'confirmé',
                    'Expert' => 'expert'
                ],
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])

            ->add('fichier' , FileType::class ,[
                'mapped' => false,
                'label' => 'CV',
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
                
            ])
            ->add('linksite' , TextType::class, [
                'required' => false,
                'label' => 'Site',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
                
            ])
            ->add('linkgit' , TextType::class, [
                'required' => false,
                'label' => 'Git',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
                
            ])
            ->add('linkfacebook' , TextType::class, [
                'required' => false,
                'label' => 'Facebook',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
                
            ])
            ->add('linkedin' , TextType::class, [
                'required' => false,
                'label' => 'Linkedin',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
                
            ])
            ->add('imgprofil' , FileType::class  , [
                'mapped' => false,
                'required' => false,
                'label' => 'Image Profil',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
                
            ])
            ->add('description' , TextareaType::class, [
                'required' => false,
                'label' => 'Description',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
                
            ])
            // ->add('skills')
            // ->add('abonne')
            // ->add('users_abonnes')
            ->add('valider',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
