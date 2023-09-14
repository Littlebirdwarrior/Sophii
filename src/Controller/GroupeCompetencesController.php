<?php

namespace App\Controller;

use App\Entity\GroupeCompetences;
use App\Form\GroupeCompetencesType;
use App\Repository\GroupeCompetencesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GroupeCompetencesController extends AbstractController
{

    #[Route('/groupe_competences', name: 'app_groupe_competences')]
    public function index( ManagerRegistry $doctrine): Response
    {
        $groupes_competences = $doctrine->getRepository( GroupeCompetences::class)->findBy([], ["titre" => "ASC"]);

        return $this->render('groupe_competences/index.html.twig', [
            'groupes_competences' => $groupes_competences,
        ]);
    }
    #[Route('/groupe_competences/add', 'groupe_competences_add', methods: ['GET', 'POST'])]
    #[Route('/groupe_competences/{id}/update', name: 'update_groupe_competences')]

    public function add(ManagerRegistry $doctrine, GroupeCompetences $groupe_competences = null, Request $request) : Response
    {
        /*$entityManager = $doctrine->getManager();
        $groupeCompetences_id = $competence->getGroupeCompetences()->getId();
        $groupeCompetences = $entityManager->getRepository(GroupeCompetences::class)->find($groupeCompetences_id);*/

        if(!$groupe_competences){
            $groupe_competences = New GroupeCompetences();
            /*$competence->setGroupeCompetences($groupeCompetences);*/
        }

        $form = $this->createForm(GroupeCompetencesType::class, $groupe_competences);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $groupe_competences = $form->getData();
            $entityManager = $doctrine->getManager();
            //(prepare selon PDO)
            $entityManager->persist($groupe_competences);
            //insert into (execute selon PDO)
            $entityManager->flush();

            //redirection vers la route des consignes
            return $this->redirectToRoute('app_groupe_competences');
        }

        //redirection vers la vue du Form
        return $this->render('groupe_competences/add.html.twig', [
            'formAddGroupeCompetences' => $form->createView(),
            'update'=> $groupe_competences->getId()
        ]);

    }

    #[Route('/groupe_competences/{id}/delete', name: 'delete_groupe_competences')]
    public function delete( ManagerRegistry $doctrine, GroupeCompetences $groupe_competences):Response
    {
        $entityManager = $doctrine->getManager();

        $entityManager->remove($groupe_competences);
        //persist pas utile, flush, execute requete
        $entityManager->flush();

        return $this->redirectToRoute('app_groupe_competences');
    }

//*details
    #[Route('/groupe_competences/{id}', name: 'show_groupe_competences')]
    public function show( GroupeCompetencesRepository $groupeCompetencesRepository, GroupeCompetences $groupe_competences): Response
    {
        $groupe_competences_id = $groupe_competences->getId();

        return $this->render('groupe_competences/show.html.twig', [
            'groupe_competences' => $groupe_competences
        ]);
    }
}
