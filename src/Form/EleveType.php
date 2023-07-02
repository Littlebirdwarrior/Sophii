<?php

namespace App\Form;

use App\Entity\Eleve;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
//operateur de resolution de portee
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Classe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class EleveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('prenom', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('nomUsage', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('genre', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('genre', ChoiceType::class, [
                'choices'  => [
                    'non renseigné' => null,
                    'Garçon' => 1,
                    'Fille' => 2,
                ],
            ])
            ->add('anniversaire', BirthdayType::class,[
                'label' => 'Date d\'anniversaire',
                'widget' => 'single_text',
            ])
            ->add('droitImage', ChoiceType::class, [
                'choices'  => [
                    'non renseigné' => null,
                    'Oui' => 2,
                    'Non' => 1,
                ],
            ])
            ->add('classe', EntityType::class, [
                'class' => Classe::class,
                'choice_label' => function (Classe $classe): string {
                    return $classe->__toString();
                }
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Eleve::class,
        ]);
    }
}
