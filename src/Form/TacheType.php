<?php

namespace App\Form;

use App\Entity\Tache;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TacheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextType::class)
            ->add('niveau', ChoiceType::class, [
                'choices' => [
                    'Débutant' => 'debutant',
                    'Intermédiaire' => 'intermediaire',
                    'Avancé' => 'avance',
                ],
            ])
            ->add('date_debut', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('date_fin', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('statut', ChoiceType::class, [
                'choices' => [
                    'À faire' => 'a_faire',
                    'En cours' => 'en_cours',
                    'Terminé' => 'termine',
                ],
            ])
            ->add('commentaire', TextareaType::class, [
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tache::class,
        ]);
    }
}
