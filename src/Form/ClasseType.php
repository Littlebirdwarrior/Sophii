<?php

namespace App\Form;

use App\Entity\Classe;
use App\Entity\Eleve;
use App\Entity\Niveau;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

//use App\Entity\Enseignant;
//use Symfony\Component\Form\Extension\Core\Type\CollectionType;
//use Symfony\Component\Validator\Constraints\NotBlank;

class ClasseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('niveau', EntityType::class, [
                'class' => Niveau::class,
                'choice_label' => function (Niveau $niveau): string {
                    return $niveau->__toString();
                    }
                ])
            ->add('libelle', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('enseignants', EntityType::class, [
                'class' => User::class,
                'required' => false,
                'multiple' => true,
                'choice_label' => function (User $enseignant) {
                    return $enseignant->__toString();
                },
            ])
            ->add('eleves', EntityType::class, [
                'class' => Eleve::class,
                'required' => false,
                'multiple' => true,
                'choice_label' => function (Eleve $eleve) {
                    return $eleve->__toString();
                },
            ])
            ->add('submit', SubmitType::class)
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Classe::class,
        ]);
    }
}
