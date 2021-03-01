<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\PostForum;
use App\Entity\CommentaireForum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class CommentairesPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextType::class, [
                'required' => true,
                'label' => 'Votre commentaire:',
                'attr' => [
                    'class' => 'votre-com',
                    'cols' => 30,
                    'rows' => 5,
                    'minlength' => 1,
                    'maxlength' => 5000 
                ]
            ])

            // ->add('date', DateTimeType::class)
            
            ->add('post', EntityType::class, [
                'required' => true,
                'class' => PostForum::class,
                'choice_label' => 'title',
            ])

            ->add('valider',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CommentaireForum::class,
        ]);
    }
}
