<?php

namespace App\Form;

use App\Entity\BulletinGroupeCompetences;
use App\Entity\GroupeCompetences;
use App\Entity\Trimestre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BulletinGroupeCompetencesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('acquisition')

            ->add('groupe_competence', EntityType::class, [
                // looks for choices from this entity
                'class' => GroupeCompetences::class,

                // uses the User.username property as the visible option string
                'choice_label' => 'titre',

                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BulletinGroupeCompetences::class,
        ]);
    }
}
