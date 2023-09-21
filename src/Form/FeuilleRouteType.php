<?php

namespace App\Form;

use App\Entity\Eleve;
use App\Entity\FeuilleRoute;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeuilleRouteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('dateFin', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('semaine', TextType::class, [
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
            ->add('eleve', EntityType::class, [
                // looks for choices from this entity
                'class' => Eleve::class,
                'choice_label' => 'prenom',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FeuilleRoute::class,
        ]);
    }
}
