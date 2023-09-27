<?php

namespace App\Form;

use App\Entity\Classe;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateEnsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('prenom',TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('tel', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('classe', EntityType::class, [
                'class' => Classe::class,
                'choice_label' => function (Classe $classe): string {
                    return $classe->getLibelle();
                }
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
            'data_class' => User::class,
        ]);
    }
}
