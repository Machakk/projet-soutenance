<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\Metiers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordStrength;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class, [
                'label' => 'Pseudo:',
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder'=>'nom-prenom'
                ]
                
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email:',
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder'=>'prenom.nom@domaine.com'
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'Veuillez accepter les conditions générales d\'utilisation.',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Veuillez accepter les conditions générales d\'utilisation.',
                    ]),
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de Passe:',

                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de renseigner un mot de passe',
                    ]),
                    new PasswordStrength([
                        'minLength' =>8,
                        'tooShortMessage' =>' le mot de passe doit contenir au moins 8 caractères',
                        'minStrength'=>4,
                        'message'=> 'Le mot de passe doit contenir au moins une lettre minscule, une lettre majuscule, un chiffre et un caractère spécial'
                    ])
                ],
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder'=> '••••••••'
                ]
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
                    'Junior' => 'junior',
                    'Confirmé' => 'confirmé',
                    'Expert' => 'expert'
                ],
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])

            ->add ('imgprofil', FileType::class, [
                'label' => 'Photo de profil:',
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'placeholder' => '.png, .jpeg, jpg',
                    'class' => 'form-control mb-3'
                ]
            ])

            
            ->add('valider' , SubmitType::class, [
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
