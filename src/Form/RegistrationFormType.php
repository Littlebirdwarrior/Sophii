<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class, ['required' => true])
            ->add('nom', TextType::class, ['required' => true])
            ->add('email',EmailType::class, ['required' => true])
            ->add('tel', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => false
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmation du mot de passe'],
                'mapped' => false,
                'invalid_message' => 'Le mot de passe et sa confirmation doivent être identiques',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{14,}$/',
                        'message' => 'Le mot de passe doit contenir au moins 1 minuscule, 1 majuscule, 
                        1 chiffre et 1 caractère spécial.',
                    ]),
                    new Length([
                        'min' => 14,
                        'minMessage' => 'Le mot de passe doit faire plus de 14 et moins de 25 caractères',
                        'max' => 25,
                    ]),
                ],
            ])
            ->add('roles', CollectionType::class, [
                'entry_type'   => ChoiceType::class,
                'entry_options'  => [
                    'label' => 'Attribuer un role : ',
                    'choices'  => [
                        'Enseignant' => 'ROLE_ENS',
                        'Parent'     => 'ROLE_PARENT',
                    ],
                ],
            ])
            ->add('RGPDconsent', CheckboxType::class, [
                'label' => 'Conditions RGPD',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Acceptez les conditions d\'utilisation',
                        //TODO(rediger les conditions de la rgpd -- en changeant dans le templates/registration/register.html.twig)
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

