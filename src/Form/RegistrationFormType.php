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

class RegistrationFormType extends AbstractType
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
            ->add('email', EmailType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
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
            ->add ('imgProfil', FileType::class, [
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'photo profil'
                ],
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('valider' , SubmitType::class, [
                'attr' => [
                    'class' => 'btn-valider-register'
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
