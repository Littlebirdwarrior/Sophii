<?php

namespace App\Form;

use App\Entity\Consigne;
use App\Entity\GroupeConsignes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsigneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('groupeConsignes', EntityType::class, [
                'class' => GroupeConsignes::class, // La classe de l'entité
                'placeholder' => 'Sélectionnez un groupe de consignes',
                'choice_label' => 'titre', // Le champ de l'entité à utiliser comme libellé des choix
                'attr' => ['class' => 'form-control'], // Les attributs HTML du champ
                // Autres options de configuration
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Consigne::class,
        ]);
    }
}
