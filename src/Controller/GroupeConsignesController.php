<?php

namespace App\Controller;

use App\Entity\Consigne;
use App\Entity\GroupeConsignes;
use App\Form\GroupeConsignesType;
use App\Repository\GroupeConsignesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//classe sur var_dump
use Symfony\Component\VarDumper\VarDumper;


class GroupeConsignesController extends AbstractController
{
    #[Route('/groupe_consignes', name: 'app_groupe_consignes')]
    public function index( ManagerRegistry $doctrine): Response
    {
        $groupe_consignes = $doctrine->getRepository( GroupeConsignes::class)->findBy([], ["titre" => "ASC"]);
        //$test = $groupe_consignes->getConsignes();

        return $this->render('groupe_consignes/index.html.twig', [
            'groupe_consignes' => $groupe_consignes,
            //'test' => $test,
        ]);
    }
    #[Route('/groupe_consignes/add', 'groupe_consignes.add', methods: ['GET', 'POST'])]
    #[Route('/groupe_consignes/{id}/update', name: 'update_groupe_consignes')]

    public function add(ManagerRegistry $doctrine, GroupeConsignes $groupe_consignes = null, Request $request) : Response
    {
        $existingConsignes = 0;
        $entityManager = $doctrine->getManager();

        //Si le groupe de consigne n'existe pas, en créer un nouveau
        if(!$groupe_consignes){
            $groupe_consignes = New GroupeConsignes();
        } else {
            // Si le groupe de consignes existe, récupérez les consignes déjà associées à ce groupe
            $existingConsignes = $groupe_consignes->getConsignes()->toArray();
        }

        //je stocke les valeurs du formulaire dans la variable form,
        $form = $this->createForm(GroupeConsignesType::class, $groupe_consignes);

        //analyse la requete HTTP et recupère les données validées par le TypeForm
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            //(prepare selon PDO)
            $entityManager->persist($groupe_consignes);
            //insert into (execute selon PDO)
            $entityManager->flush();

            // Maintenant que le groupe a été sauvegardé, nous pouvons ajouter ou supprimer les consignes associées à celui-ci
            $newConsignes = $form->get('consignes')->getData();

            //si le groupe de consigne n'existe pas
            if(!$existingConsignes == 0 ){
                foreach ($existingConsignes as $consigne){
                    //Si une consigne existante n'est pas présente dans les nouvelles consignes, la retirer
                    if(!$newConsignes->contains($consigne)){
                        $groupe_consignes->removeConsigne($consigne);
                    }
                }
            }

            foreach ($newConsignes as $newConsigne){
                //Si une nouvelle consigne n'est pas déjà associée au groupe
                if(!$groupe_consignes->getConsignes()->contains($newConsigne)){
                    $groupe_consignes->addConsigne($newConsignes);
                }
            }

            //j uptate consigne
            $entityManager->persist($groupe_consignes);
            $entityManager->flush();

            //redirection vers la route des consignes
            return $this->redirectToRoute('app_groupe_consignes');
        }

        //redirection vers la vue du Form
        return $this->render('groupe_consignes/add.html.twig', [
            'formAddGroupeConsignes' => $form->createView(),
            'update'=> $groupe_consignes->getId(),
            'test' => $groupe_consignes,
        ]);

    }

    #[Route('/groupe_consignes/{id}/delete', name: 'delete_groupe_consignes')]
    public function delete( ManagerRegistry $doctrine, GroupeConsignes $groupe_consignes):Response
    {
        $entityManager = $doctrine->getManager();

        $entityManager->remove($groupe_consignes);
        //persist pas utile, flush, execute requete
        $entityManager->flush();

        return $this->redirectToRoute('app_groupe_consignes');
    }

//*details
    #[Route('/groupe_consignes/{id}', name: 'show_groupe_consignes')]
    public function show( GroupeConsignesRepository $groupeConsignesRepository, GroupeConsignes $groupe_consignes): Response
    {
        $groupe_consignes_id = $groupe_consignes->getId();

        return $this->render('groupe_consignes/show.html.twig', [
            'groupe_consignes' => $groupe_consignes,
        ]);
    }
}
