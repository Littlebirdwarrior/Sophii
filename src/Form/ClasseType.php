<?php

namespace App\Form;

use App\Entity\Classe;
use App\Entity\Niveau;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            /*->add('enseignant', EntityType::class, [
                'label' => 'Enseignant',
                'class' => Enseignant::class,
                'choice_label' => function (Enseignant $enseignant): string {
                    return $enseignant->__toString();
                }
            ])*/

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
