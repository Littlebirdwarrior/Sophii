<?php

namespace App\Form;

use App\Entity\Classe;
use App\Entity\Enseignant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType as SymfonyEmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EnseignantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, [
            'attr' => ['class' => 'form-control']
        ])
        ->add('nomUsage', TextType::class, [
            'attr' => ['class' => 'form-control']
        ])
        ->add('prenom', TextType::class, [
            'attr' => ['class' => 'form-control']
        ])
        ->add('mail', SymfonyEmailType::class, [
            'label' => 'Adresse email',
        ])
        ->add('telephone', TextType::class, [
            'attr' => ['class' => 'form-control']
        ])
        ->add('password', TextType::class, [
            'attr' => ['class' => 'form-control']
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
            'data_class' => Enseignant::class,
        ]);
    }
}
