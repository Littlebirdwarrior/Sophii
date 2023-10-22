<?php

namespace App\Form;

use App\Entity\Eleve;
use App\Model\SearchData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //'q' pour query
        $builder
            ->add('q', TextType::class, [
                'attr' => [
                    'placeholder' => 'Recherche via un mot clé...'
                ],
                'empty_data' => '',
                'required' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Rechercher',
            ]);
    }

    /*
     * Permet de mettre les valeurs par défault
     * */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            /*
             * classe SearchData dans le modele
             * */
            'data_class' => SearchData::class,
            'method' => 'GET',
            //desactive la protection car n'est pas utile
            'csrf_protection' => false
        ]);
    }
}
