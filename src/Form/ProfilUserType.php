<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\Skills;
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
                'label' => 'Pseudo:',
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-3'
                ],
                'pattern' => "[A-Za-z0-9]",
                
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
                'label' => 'Mot de passe:',
                'required' => false
            ])

            ->add('metier', EntityType::class, [
                'label' => 'Métier:',
                'required' => true,
                'class' => Metiers::class,
                'choice_label' => 'metier',
                
            ])
    
            ->add('niveau', ChoiceType::class, [
                'label' => 'Niveau:',
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

            ->add('fichier' , FileType::class ,[
                'mapped' => false,
                'label' => 'Votre CV',
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
                
            ])
            ->add('linksite' , TextType::class, [
                'label' => 'Site:',
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
                
            ])
            ->add('linkgit' , TextType::class, [
                'required' => false,
                'label' => 'Git:',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
                
            ])
            ->add('linkfacebook' , TextType::class, [
                'required' => false,
                'label' => 'Facebook:',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
                
            ])
            ->add('linkedin' , TextType::class, [
                'required' => false,
                'label' => 'Linkedin:',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
                
            ])
            ->add('imgprofil' , FileType::class  , [
                'mapped' => false,
                'required' => false,
                'label' => 'Photo de Profil:',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
                
            ])
            ->add('description' , TextareaType::class, [
                'required' => false,
                'label' => 'Description:',
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
                
            ])
            ->add('skills', EntityType::class, [
                'required' => false,
                'class' => Skills::class,
                'choice_label' => 'title',
                'multiple' => true,
                'expanded' => true  
             ])

            ->add('valider',SubmitType::class, [
                'attr' => [
                    'class' => 'btn-valide-post w-100 '
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
