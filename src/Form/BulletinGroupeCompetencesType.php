<?php

namespace App\Form;

use App\Entity\BulletinGroupeCompetences;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BulletinGroupeCompetencesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('acquisition')
            ->add('bulletin')
            ->add('groupe_competence')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BulletinGroupeCompetences::class,
        ]);
    }
}
