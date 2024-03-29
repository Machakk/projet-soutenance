<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentairePostUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('content', TextareaType::class, [
                'required' => true,
                'label' => 'Votre commentaire:',
                'attr' => [
                    'class' => 'votre-com',
                    'cols' => 30,
                    'rows' => 5,
                    'minlength' => 1, //please fill this field
                    'maxlength' => 1000 
                ]                
            ])
            

            ->add('valider', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-outline-success',
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
