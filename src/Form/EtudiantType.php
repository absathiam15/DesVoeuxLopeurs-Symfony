<?php

namespace App\Form;

use App\Entity\Etudiant;
use App\Entity\Chambre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Matricule', null, [
                'attr'=>[
                    'readonly'=>true
                ]
            ])
            ->add('Prenom')
            ->add('Nom')
            ->add('Adresse', null, [
                'label'=>false,
                'required'=>false
            ])
            ->add('Telephone') 
            ->add('Date_de_Naissance', null, [
                // 'widget'=>'single_text'
            ])
            ->add('email')
            ->add('Bourse', ChoiceType::class, [
                'choices'=>[
                    'Type de bourse' => '',
                    'BE' => 'BE',
                    'DB' => 'DB'
                ],
                'label' => false,
                'required' => false
            ])
            ->add('Type_Etudiant', ChoiceType::class, [
                'choices'=>[
                    'Type d\'etudiant' => '',
                    'Boursier loge' => 'boursierloge',
                    'Boursier non loge' => 'boursiernonloge',
                    'Non boursier' => 'nonboursier'
                ]
            ])
            ->add('Chambre', EntityType::class,[
                'class' => Chambre::class,
                'choice_label' => 'numchambre',
                'label' => false
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
