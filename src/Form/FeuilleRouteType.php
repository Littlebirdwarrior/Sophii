<?php

namespace App\Form;

use App\Entity\FeuilleRoute;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeuilleRouteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut')
            ->add('dateFin')
            ->add('semaine')
            ->add('validation')
            ->add('eleve')
            ->add('activites')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FeuilleRoute::class,
        ]);
    }
}
