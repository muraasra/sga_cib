<?php

namespace App\Form;

use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints as Assert;



class StagiaireSecType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('addresse')
            ->add('date_nais', DateType::class,[
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('n_cni')
            ->add('sexe', ChoiceType::class, [
                'choices' => [
                    'Masculin' => 'Masculin',
                    'Féminin' => 'Féminin',
                ],
            ])
            ->add('email')
            ->add('nationalite', ChoiceType::class, [
                'choices' => [
                    'camerounaise' => 'Camerounaise',
                    'Autre' => 'Autre',
                ],
            ])
            ->add('nom')
            ->add('prenom')
            ->add('telephone')
            ->add('filiere' ,ChoiceType::class, [
                'choices' => [
                    ''=>'',
                    'TI'=>'TI',
                    
                ],
    
            ])
            ->add('etablissement', ChoiceType::class, [
                'choices' => [
                    'Lycee bilingue de Bafoussam' => 'Lycee bilingue de Bafoussam',
                    'Lycee classique de Bafoussam' => 'Lycee classique de Bafoussam',
                    'Lycee bilingue de Ndiandam' => 'Lycee bilingue de Ndiandam',
                    'Autre' => 'Autre',
                    ],
                ])
           
            ->add('classe', ChoiceType::class, [
                'choices'=>[
                    '1ère' => '1ère',
                    'Terminale' => 'Treminale',
                ],
                'label'=>'Classe',
            ])
            ->add('cv', FileType::class, [
                'label' => 'CV (fichier PDF)',
                'mapped'=>false,
                'required'=>false,
                'constraints'=>[
                    new Assert\NotBlank([
                        'message' => 'Veuillez télécharger un fichier.',
                    ]),
                    new File([
                        'maxSize'=>'2048k',
                        'mimeTypes'=>[
                            'application/pdf',
                            'application/x-pdf',
                            ],
                        'mimeTypesMessage'=>'Imported un fichier PDF ',
                        ]),
                    
            ],],)
            ->add('lettre_motivation', FileType::class, [
                'label' => 'Lettre de motivation (fichier PDF)',
                'mapped'=>false,
                'required'=>false,
                'constraints'=>[
                    new Assert\NotBlank([
                        'message' => 'Veuillez télécharger un fichier.',
                    ]),
                    new File([
                        'maxSize'=>'2048k',
                        'mimeTypes'=>[
                            'application/pdf',
                            'application/x-pdf',
                            ],
                        'mimeTypesMessage'=>'Imported un fichier PDF ',
                        ]),
                    
                    ],],)
            ->add('type_stage',ChoiceType::class,[
                'choices'=>[
                    'Stage Academique' => 'stage_academique',
                    'Stage Professinnel' => 'stage_professinnel',
                    'Stage de Vacance' => 'stage_de_vacance',
                ],
            ])
            ->add('date_debut', DateType::class,[
                    'label'=>'Date debut de stage',
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'attr' => ['class' => 'js-datepicker'],
                ])
            ->add('date_fin', DateType::class,[
                'label'=>'Date fin de stage',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'js-datepicker'],
                ])
            
            ->add('enregistrer',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stagiaire::class,
        ]);
    }
}
