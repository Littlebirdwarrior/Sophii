<?php

namespace App\Form;

use App\Entity\Famille;
use App\Entity\ParentEleve;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType as SymfonyEmailType;

class ParentEleveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('genre', ChoiceType::class, [
                'choices'  => [
                    'non renseigné' => null,
                    'Oui' => 0,
                    'Non' => 1,
                ],
            ])
            ->add('qualite', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('nomUsage', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('prenom', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('profession', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('adresse', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('cp', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('ville', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('adresse', SymfonyEmailType::class, [
                'label' => 'Adresse email',
            ])
            ->add('telephone', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('password', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('famille', EntityType::class, [
                'class' => Famille::class,
                'choice_label' => function (Famille $famille): string {
                    return $famille->__toString();
                }
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ParentEleve::class,
        ]);
    }
}
