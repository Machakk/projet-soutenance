<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\Metiers;
use App\Entity\PostForum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PostsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'Titre:',
                'attr' => [
                    'minlength' => 3,
                    'maxlength' => 30,
                ],
                'help' => 'Un titre est obligatoire'
            ])
            ->add('content' , TextareaType::class, [
                'required' => true,
                'label' => 'Contenu:',
                'attr' => [
                    'minlength' => 20,
                    'maxlength' => 5000
                ],
                'help' => 'Maximum 5000 caractères'
            ])
            ->add('img' , FileType::class , [
                'label' => 'Image:',
                'required' => false,
                'mapped' =>false,
                'attr' => [
                    'placeholder' => 'Image du post'
                ],
                'help' => 'png, jpg ou jpeg'
            ])
            // ->add('date', DateTimeType::class, [
            //     'date_label' => 'Starts On'
            // ])

            ->add('metier', EntityType::class, [
                'label' => 'Métier:',
                'required' => true,
                'class' => Metiers::class,
                'choice_label' => 'metier',                
            ])

            ->add('valider',SubmitType::class, [
                'attr' => [
                    'class' => 'btn-valide-post w-100',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PostForum::class,
        ]);
    }
}
