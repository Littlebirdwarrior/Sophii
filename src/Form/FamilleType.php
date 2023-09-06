<?php

namespace App\Form;

use App\Entity\Famille;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FamilleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('parents', CollectionType::class, [
                    'label' => 'Parent',
                    'entry_type' => User::class,
                    'choice_label' => function (User $enseignant): string {
                        return $enseignant->__toString();
                    }
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Famille::class,
        ]);
    }
}
