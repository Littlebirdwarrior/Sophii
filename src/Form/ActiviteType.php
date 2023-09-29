<?php

namespace App\Form;

use App\Entity\Activite;
use App\Entity\GroupeCompetences;
use App\Entity\GroupeConsignes;
use App\Entity\Image;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
            ->add('validation', ChoiceType::class, [
                'choices' => [
                    'Validée' => true,
                    'Non-validée' => false,
                ],
                'expanded' => true, // Pour afficher les boutons radio
                'required' => false, // Ou false si vous le souhaitez
                'placeholder' => false, // Exclure le choix "none"

            ])
            ->add('groupeconsignes', EntityType::class, [
                'label' => 'appartient au groupe de consignes :',
                'class' => GroupeConsignes::class,
                'choice_label' => 'titre',
            ])
            ->add('image', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false,
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
