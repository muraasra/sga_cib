<?php

namespace App\Form;

use App\Entity\Courrier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourrierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero_odre')
            ->add('date_reception')
            ->add('expediteur')
            ->add('destinataire')
            ->add('objet')
            ->add('description')
            ->add('type_courrier')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Courrier::class,
        ]);
    }
}
