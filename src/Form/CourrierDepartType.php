<?php

namespace App\Form;

use App\Entity\Courrier;
use DateTime;
use Doctrine\DBAL\Types\DateTimeType;
use PHPUnit\TextUI\XmlConfiguration\File as XmlConfigurationFile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CourrierDepartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('date_reception',DateType::class,[
                'label' => 'Date de réception',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
               'required' => false,
            ])
            ->add('expediteur',TextType::class, [
                'attr'=>[

                 'value' => 'CENADI',
                 'readonly' => true,
                 ]
            ])
            ->add('destinataire')
            ->add('objet')
            ->add('description', TextType::class)
            ->add('type_courrier')
            ->add('brochure', FileType::class, [
                'label' => 'Pieces jointe du courrier (fichier PDF)',
                'mapped'=>false,
                'required'=>false,
                'constraints'=>[
                    new File([
                        'maxSize'=>'2048k',
                        'mimeTypes'=>[
                            'application/pdf',
                            'application/x-pdf',
                            ],
                        'mimeTypesMessage'=>'Imported un fichier PDF ',
                        ]),
                    
                ]
                // 'label' => 'Pieces jointe du courrier (fichier PDF)',

                // // unmapped means that this field is not associated to any entity property
                // 'mapped' => false,

                // // make it optional so you don't have to re-upload the PDF file
                // // every time you edit the Product details
                // 'required' => false,

                // // unmapped fields can't define their validation using attributes
                // // in the associated entity, so you can use the PHP constraint classes
                // 'constraints' => [
                //     new File([
                //         'maxSize' => '2048k',
                //         'mimeTypes' => [
                //             'application/pdf',
                //             'application/x-pdf',
                //         ],
                //         'mimeTypesMessage' => 'Imported un fichier PDF ',
                //     ])
                // ],
            ])
            // ...
            ->add('Enregistrer',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Courrier::class,
        ]);
    }
}
