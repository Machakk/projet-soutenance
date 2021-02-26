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
                'label' => 'Titre:'
            ])
            ->add('content' , TextareaType::class, [
                'label' => 'Contenu:',
            ])
            ->add('img' , FileType::class , [
                'label' => 'Image:',
                'required' => false,
                'mapped' =>false,
            ])
            // ->add('date',DateTimeType::class)

            ->add('metier', EntityType::class, [
                'label' => 'Métier:',
                'required' => true,
                'class' => Metiers::class,
                'choice_label' => 'metier',
                
            ])

            ->add('valider',SubmitType::class, [
                'attr' => [
                    'class' => 'btn-valide-post w-100 ',
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
