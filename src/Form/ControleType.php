<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ControleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('statut', ChoiceType::class, [
            'choices' => [
                'Accepté' => 'accepte',
                'Refusé' => 'refuse',
            ],
            'placeholder' =>'Choissisez le statut du controle',
            'label' => 'Statut du contrôle',
            'required' => true,
        ])
        ->add('pv', FileType::class, [
            'label' => 'Importer le PV (PDF uniquement)',
            'required' => false, // le PV est requis seulement si accepté
            'constraints' => [
                new File([
                    'mimeTypes' => ['application/pdf'],
                    'mimeTypesMessage' => 'Veuillez importer un fichier PDF valide',
                ]),
            ],
        ])
        ->add('raison',TextareaType::class, ['label' => 'Entrer les raisons de votre refus'])
        ->add('Enregistrer', SubmitType::class, ['label' => 'Enregistrer le contrôle'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
