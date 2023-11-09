<?php

namespace App\Form;

use App\Entity\Classe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;




class UpdateEnsType extends AbstractType
{
    /*
     * J'importe l'authorisation checker
     * */
    private AuthorizationCheckerInterface $authorizationChecker;
    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('prenom', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('tel', TextType::class, [
                'attr' => ['class' => 'form-control'],
            ])
            ->add('image', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false,
            ])
            ->add('submit', SubmitType::class);

            // Événement PRE_SET_DATA pour conditionner l'affichage du champ 'classe' au role admin
            $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            /*je définis ma variable isAdmin en fonction du role admin,
            si le role admin existe*/
            $isAdmin = $this->authorizationChecker->isGranted('ROLE_ADMIN');

            if ($isAdmin) {
                $form->add('classe', EntityType::class, [
                    'class' => Classe::class,
                    'choice_label' => 'libelle',
                    // Ajoutez d'autres options si nécessaire
                ]);
            }
        });
    }
}
