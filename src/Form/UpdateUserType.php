<?php

namespace App\Form;
use App\Entity\User;
use App\Entity\Classe;
use App\Entity\Eleve;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateUserType extends AbstractType
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
            ->add('qualite', ChoiceType::class, [
                'choices'  => [
                    'non renseigné' => null,
                    'Père' => 1,
                    'Mère' => 2,
                    'Autre' => 3,
                ],
            ])
            ->add('profession',TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('adresse',TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('cp',TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('ville',TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('tel', TextType::class, [
                'attr' => ['class' => 'form-control']
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
