<?php

namespace App\Form;

use App\Entity\Bulletin;
use App\Entity\BulletinGroupeCompetences;
use App\Entity\Trimestre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BulletinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('trimestre', EntityType::class, [
                // looks for choices from this entity
                'class' => Trimestre::class,
                'choice_label' => 'libelle',

            ])
            ->add('bulletinGroupeCompetences', CollectionType::class, [
                'entry_type' => BulletinGroupeCompetencesType::class,
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bulletin::class,
        ]);
    }
}
