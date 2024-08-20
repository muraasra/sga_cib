<?php

namespace App\Form;

use App\Entity\Stage;
use App\Entity\Stagiaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_debut',DateType::class, [
                'widget' =>'single_text'
            ])
            ->add('date_fin',DateType::class, [
                'widget' =>'single_text'
            ])
            ->add('theme')
            ->add('stagiaire',EntityType::class,[
                'class'=>Stagiaire::class,
            ])
            ->add('evaluation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
