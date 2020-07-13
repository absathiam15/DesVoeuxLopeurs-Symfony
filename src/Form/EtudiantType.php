<?php

namespace App\Form;

use App\Entity\Bourse;
use App\Entity\Chambre;
use App\Entity\Etudiant;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom')
            ->add('nom')
            ->add('email')
            ->add('tel')
            ->add('date_naiss', DateType::class, [
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',
            ])
            ->add('type', ChoiceType::class,[
                'choices' => [
                    'BoursierLogé' => 'BoursierLogé',
                    'BoursierNonLogé' => 'BoursierNonLogé',
                    'NonBoursier' => 'NonBoursier'
                ],
                'attr' => ['onChange' => 'typeEtudiant()'],
            ])
            ->add('adresse',TextType::class,[
                'row_attr' => ['id' => 'adresse'],
                'required' => false,
                'empty_data' => NULL,
            ])
            ->add('Chambre', EntityType::class, array(
                'class'=>Chambre::class,
                'placeholder'=>'Choisir une Chambre',
                'choice_label'=>function($chambre){
                    return $chambre->getNumChambre();
                },
                'row_attr' => ['id' => 'numChambre'],
                'required' => false,
                'empty_data' => NULL,

            ))
            ->add('bourse',EntityType::class,[
                'class' => Bourse::class,
                'choice_label' => 'bourse',
                'placeholder'=>'Choisir un type de Bourse',
                'row_attr' => ['id' => 'bourse'],
                'required' => false,
                'empty_data' => NULL,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
