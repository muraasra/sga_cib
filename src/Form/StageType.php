<?php

namespace App\Form;

use App\Entity\Stage;
use App\Entity\Stagiaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\File;
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
                'widget' =>'single_text',
            ])
            ->add('theme')
            ->add('rapport', FileType::class, [
                'label' => 'Rapport de stage (fichier PDF)',
                'mapped'=>false,
                'required'=>false,
                'constraints'=>[
                    new Assert\NotBlank([
                        'message' => 'Veuillez télécharger un fichier.',
                    ]),
                    new File([
                        'maxSize'=>'20480k',
                        'mimeTypes'=>[
                            'application/pdf',
                            'application/x-pdf',
                            ],
                        'mimeTypesMessage'=>'Imported un fichier PDF ',
                        ]),
                    
                    ],],)
            //->add('stagiaire')
            //->add('evaluation')
            ->add('enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
