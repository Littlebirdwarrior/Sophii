<?php

namespace App\Form;

use App\Entity\Eleve;
use App\Entity\Famille;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FamilleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            /*->add('parents', EntityType::class, [
                    'class' => User::class,
                    'choice_label'=> function(User $parents){
                        foreach ($parents as $parent) {
                            $parent->getNom();
                        }
                        return
                    },
                    'required' => false,
                ])*/
            /*->add('eleves', CollectionType::class, [
                    'label' => 'Eleve',
                    'entry_type' => EntityType::class,
                    'entry_options' => [
                        'class' => 'App\Entity\Eleve', // Entité à partir de laquelle vous choisissez les élèves
                        'choice_label' => 'prenom', // Champ à utiliser comme label
                    ],
                ])*/
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Famille::class,
        ]);
    }
}
