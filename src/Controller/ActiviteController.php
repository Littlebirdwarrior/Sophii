<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Entity\Classe;
use App\Entity\Competence;
use App\Form\ActiviteType;
use App\Repository\ActiviteRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActiviteController extends AbstractController
{
    #[Route('/activite', name: 'app_activite')]
    public function index( ManagerRegistry $doctrine): Response
    {
        $activites = $doctrine->getRepository( Activite::class)->findBy([], ["titre" => "ASC"]);

        return $this->render('activite/index.html.twig', [
            'activites' => $activites,
        ]);
    }

    #[Route('/activite/add', 'activite.add', methods: ['GET', 'POST'])]
    #[Route('/activite/{id}/update', name: 'update_activite')]
    public function add(ManagerRegistry $doctrine, Activite $activite = null, Request $request) : Response
    {
        $entityManager = $doctrine->getManager();

        if(!$activite){
            $activite = New Activite();
        }

        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $activite = $form->getData();
            $entityManager = $doctrine->getManager();
            //(prepare selon PDO)
            $entityManager->persist($activite);
            //insert into (execute selon PDO)
            $entityManager->flush();

            //redirection vers la route des classes
            return $this->redirectToRoute('app_activite');
        }

        //redirection vers la vue du Form
        return $this->render('activite/add.html.twig', [
            'formAddActivite' => $form->createView(),
            'update' => $activite->getId()
        ]);

    }

    #[Route('/activite/{id}/delete', name: 'delete_activite')]
    public function delete( ManagerRegistry $doctrine, Activite $activite):Response
    {
        $entityManager = $doctrine->getManager();

        $entityManager->remove($activite);
        //persist pas utile, flush, execute requete
        $entityManager->flush();

        return $this->redirectToRoute('app_activite');
    }


//*details
    #[Route('/activite/{id}', name: 'show_activite')]
    public function show( ActiviteRepository $activiteRepository, Activite $activite): Response
    {
        $activite_id = $activite->getId();

        return $this->render('activite/show.html.twig', [
            'activite' => $activite
        ]);
    }

}
