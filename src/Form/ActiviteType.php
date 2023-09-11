<?php

namespace App\Form;

use App\Entity\Activite;
use App\Entity\GroupeCompetences;
use App\Entity\GroupeConsignes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActiviteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre',TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('validation', RadioType::class, [
                'required' => false
            ])
            ->add('groupeconsignes', EntityType::class, [
                'class' => GroupeConsignes::class,
                'choice_label' => 'titre',
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activite::class,
        ]);
    }
}
