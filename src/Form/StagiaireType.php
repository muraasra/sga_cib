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



class StagiaireType extends AbstractType
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
                    'Genie logiciels' => 'Genie logiciels',
                    'Cybersécurité' => 'Cybersécurité',
                    'Systeme et réseaux ' => 'Systeme et réseaux',
                    'Intelligence artificielle' => 'Intelligence artificielle',
                    'Big Data et analyse de données'=> 'Big Data et analyse de données',
                    'Systèmes embarqués ' => 'Systèmes embarqués',
                    'Informatique industrielle' => 'Informatique industrielle',
                    'Systemes d\'information' => 'Systemes d\'information',
                ],
    
            ])
            ->add('etablissement', ChoiceType::class, [
                'choices' => [
                    'Institut Africaine d\'Informatique' => 'Institut Africaine d\'Informatique',
                    'IUES/Insam' => 'IUES/Insam',
                    'Institut universitaire la pointe' => 'Institut universitaire la pointe',
                    'Institut Catholique de Bafoussam' => 'Institut Catholique de Bafoussam',
                    'Autre' => 'Autre',
                    ],
                ])
           
            ->add('classe', ChoiceType::class, [
                'choices'=>[
                    '1ère année' => '1ère année',
                    '2ème année' => '2ème année',
                    'License' => 'License',
                    'Master 1' => 'Master 1',
                    'Master 2' => 'Master 2',
                ],
                'label'=>'Niveau',
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
