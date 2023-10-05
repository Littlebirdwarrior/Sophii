<?php

namespace App\Form;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

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
            ->add('qualite', ChoiceType::class, [
                'choices'  => [
                    'Père' => "père",
                    'Mère' => "mère",
                    'Autre' => "autre",
                ],
            ])
            ->add('autorite', CheckboxType::class, [
                'label' => 'À l\'autorité parentale',
                'mapped' => false,
            ])
            ->add('RGPDconsent', CheckboxType::class, [
                'label' => 'Conditions RGPD',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Acceptez les conditions d\'utilisation',
                    ]),
                ],
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
