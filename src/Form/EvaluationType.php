<?php

namespace App\Form;

use App\Entity\Evaluation;
use PhpParser\Node\Stmt\Label;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvaluationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('assuiduite', ChoiceType::class,[
                'label'=>'Assuiduite',
                'choices' =>[

                    'Excellent'=>'excellent',
                    'Tres bien'=>'tres_bien',
                    'Bien'=>'bien',
                    'Assez-bien'=>'assez_bien',
                    'Passable'=>'passable',
                    'Insuffisant'=>'insuffisant',
                ],
                'multiple' => false, 
                'expanded' => true

            ])
            ->add('ponctualite', ChoiceType::class,[
                'label'=>'Ponctualite',
                'choices' =>[

                    'Excellent'=>'excellent',
                    'Tres bien'=>'tres_bien',
                    'Bien'=>'bien',
                    'Assez-bien'=>'assez_bien',
                    'Passable'=>'passable',
                    'Insuffisant'=>'insuffisant',
                ],
                'multiple' => false, 
                'expanded' => true

            ])
            ->add('disponibilite', ChoiceType::class,[
                'label' => 'Disponibilite, propreté et respect des règles de securité',
                'choices' =>[

                    'Excellent'=>'excellent',
                    'Tres bien'=>'tres_bien',
                    'Bien'=>'bien',
                    'Assez-bien'=>'assez_bien',
                    'Passable'=>'passable',
                    'Insuffisant'=>'insuffisant',
                ],
                'multiple' => false, 
                'expanded' => true

            ])
            ->add('interet', ChoiceType::class,[
                'label'=>'Intéret pour l\'entreprise',
                'choices' =>[

                    'Excellent'=>'excellent',
                    'Tres bien'=>'tres_bien',
                    'Bien'=>'bien',
                    'Assez-bien'=>'assez_bien',
                    'Passable'=>'passable',
                    'Insuffisant'=>'insuffisant',
                ],
                'multiple' => false, 
                'expanded' => true

            ])
            ->add('respect', ChoiceType::class,[
                'label'=>'Respect de la hiérachie',
                
                'choices' =>[

                    'Excellent'=>'excellent',
                    'Tres bien'=>'tres_bien',
                    'Bien'=>'bien',
                    'Assez-bien'=>'assez_bien',
                    'Passable'=>'passable',
                    'Insuffisant'=>'insuffisant',
                ],
                'multiple' => false, 
                'expanded' => true

            ])
            ->add('esprit', ChoiceType::class,[
                'label'=>'Esprit d\'équipe et initiatives',
                'choices' =>[

                    'Excellent'=>'excellent',
                    'Tres bien'=>'tres_bien',
                    'Bien'=>'bien',
                    'Assez-bien'=>'assez_bien',
                    'Passable'=>'passable',
                    'Insuffisant'=>'insuffisant',
                ],
                'multiple' => false, 
                'expanded' => true

            ])
            ->add('aptitude', ChoiceType::class,[
                'label'=>'Aptitude à l\'execution des taches',
                
                'choices' =>[

                    'Excellent'=>'excellent',
                    'Tres bien'=>'tres_bien',
                    'Bien'=>'bien',
                    'Assez-bien'=>'assez_bien',
                    'Passable'=>'passable',
                    'Insuffisant'=>'insuffisant',
                ],
                'multiple' => false, 
                'expanded' => true

            ])
            ->add('organisation', ChoiceType::class,[
                'label'=>'Organisation de son poste de travail',
                'choices' =>[

                    'Excellent'=>'excellent',
                    'Tres bien'=>'tres_bien',
                    'Bien'=>'bien',
                    'Assez-bien'=>'assez_bien',
                    'Passable'=>'passable',
                    'Insuffisant'=>'insuffisant',
                ],
                'multiple' => false, 
                'expanded' => true

            ])
            ->add('application', ChoiceType::class,[
                'label'=>'Application et soin à l\'execution des taches',
                
                'choices' =>[

                    'Excellent'=>'excellent',
                    'Tres bien'=>'tres_bien',
                    'Bien'=>'bien',
                    'Assez-bien'=>'assez_bien',
                    'Passable'=>'passable',
                    'Insuffisant'=>'insuffisant',
                ],
                'multiple' => false, 
                'expanded' => true

            ])
            ->add('recherche', ChoiceType::class,[
                'label'=>'Recherche et progresion dans le theme(rendement)',
                'choices' =>[

                    'Excellent'=>'excellent',
                    'Tres bien'=>'tres_bien',
                    'Bien'=>'bien',
                    'Assez-bien'=>'assez_bien',
                    'Passable'=>'passable',
                    'Insuffisant'=>'insuffisant',
                ],
                'multiple' => false, 
                'expanded' => true

            ])
            ->add('stage',)
        ->add('Enregistrer', SubmitType::class);
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evaluation::class,
        ]);
    }
}
