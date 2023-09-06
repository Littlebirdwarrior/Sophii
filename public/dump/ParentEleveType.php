<?php

namespace dump;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType as SymfonyEmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParentEleveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('authorite', ChoiceType::class, [
                'label' => 'Authorité parentale',
                'choices'  => [
                    'non renseigné' => 1,
                    'Oui' => 0,
                    'Non' => 1,
                ],
            ])
            ->add('qualite', ChoiceType::class, [
                'label' => 'mère ou père de l\'enfant',
                'attr' => ['class' => 'form-control'],
                'choices'  => [
                    'non renseigné' => 'nr',
                    'mère' => 'mère',
                    'père' => 'père',
                ],

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
            ->add('mail', SymfonyEmailType::class, [
                'label' => 'Adresse email',
            ])
            ->add('tel', TextType::class, [
                'label' => 'téléphone',
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
