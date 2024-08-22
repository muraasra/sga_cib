<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RechercheStagiaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom',TextType::class,[
            'label' => 'nom',
            'required' => false,
            'attr' => ['placeholder' => 'Numero d\'ordre...']
        ])
        ->add('filiere',TextType::class,[
            'label' => 'filiere',
            'required' => false,
            'attr' => ['placeholder' => 'Expediteur...']
        ])
        ->add('niveau',TextType::class,[
            'label' => 'niveau',
            'required' => false,
            'attr' => ['placeholder' => 'Niveau...']
        ])
        ->add('theme',TextType::class,[
            'label' => 'theme',
            'required' => false,
            'attr' => ['placeholder' => 'Theme...']
        ])
        ->add('encadreur',TextType::class,[
            'label' => 'Encadreur',
            'required' => false,
            'attr' => ['placeholder' => 'encadreur...']
        ])
        ->add('Rechercher',SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
