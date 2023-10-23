<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Entity\GroupeCompetences;
use App\Form\CompetenceType;
use App\Repository\CompetenceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompetenceController extends AbstractController
{
    #[Route('/competence', name: 'app_competence')]
    public function index( ManagerRegistry $doctrine): Response
    {
        $competences = $doctrine->getRepository( Competence::class)->findBy([], ["libelle" => "ASC"]);

        return $this->render('competence/index.html.twig', [
            'competences' => $competences,
        ]);
    }
    #[Route('/competence/add', name: 'app_competence_add', methods: ['GET', 'POST'])]
    #[Route('/competence/{id}/update', name: 'update_competence')]

    public function add(ManagerRegistry $doctrine, Competence $competence = null, Request $request) : Response
    {

        if(is_null($competence)){
            $competence = New Competence();
        }

        /*$entityManager = $doctrine->getManager();
        $groupeCompetencesId = $competence->getGroupecompetences()->getId();
        $groupeCompetences = $entityManager->getRepository(GroupeCompetences::class)->find($groupeCompetencesId);*/

        $form = $this->createForm(CompetenceType::class, $competence);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $competence = $form->getData();
            $entityManager = $doctrine->getManager();
            //(prepare selon PDO)
            $entityManager->persist($competence);
            //insert into (execute selon PDO)
            $entityManager->flush();

            //redirection vers la route des consignes
            return $this->redirectToRoute('app_competence');
        }

        //redirection vers la vue du Form
        return $this->render('competence/add.html.twig', [
            'formAddCompetence' => $form->createView(),
            'update'=> $competence->getId()
        ]);

    }

    #[Route('/competence/{id}/delete', name: 'delete_competence')]
    public function delete( ManagerRegistry $doctrine, Competence $competence):Response
    {
        $entityManager = $doctrine->getManager();

        $entityManager->remove($competence);
        //persist pas utile, flush, execute requete
        $entityManager->flush();

        return $this->redirectToRoute('app_competence');
    }

//*details
    /*#[Route('/competence/{id}', name: 'show_competence')]
    public function show( CompetenceRepository $competenceRepository, Competence $competence): Response
    {
        $competence_id = $competence->getId();

        return $this->render('competence/show.html.twig', [
            'competence' => $competence
        ]);
    }*/
}
