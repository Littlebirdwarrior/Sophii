<?php

namespace App\Form;

use App\Entity\GroupeCompetences;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupeCompetencesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre',
                'attr' => ['class' => 'form-control']
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'tinymce'], // Tiny Moxiecode Content Editor, plugin qui permet mise en forme textearea
                //fitre aussi les données, a implementer plus tard
                //https://www.tiny.cloud/docs/tinymce/6/php-projects/
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GroupeCompetences::class,
        ]);
    }
}
