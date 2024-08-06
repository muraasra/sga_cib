<?php

namespace App\Form;

use Doctrine\DBAL\Types\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numeroOrdre',TextType::class,[
                'label' => 'numeroOrdre',
                'required' => false,
                'attr' => ['placeholder' => 'Numero d\'ordre...']
            ])
            ->add('expediteur',TextType::class,[
                'label' => 'Expediteur',
                'required' => false,
                'attr' => ['placeholder' => 'Expediteur...']
            ])
            ->add('destinataire',TextType::class,[
                'label' => 'destinataire',
                'required' => false,
                'attr' => ['placeholder' => 'Destinataire...']
            ])
            
            
            
            ->add('Rechercher',SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
}
