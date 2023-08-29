<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Form\EleveType;
use App\Repository\EleveRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EleveController extends AbstractController
{
    #[Route('/eleve', name: 'app_eleve')]
    public function index( ManagerRegistry $doctrine ): Response
    {
        $eleves = $doctrine->getRepository( Eleve::class)->findBy([], ["nom" => "ASC"]);
        
        return $this->render('eleve/index.html.twig', [
            'eleves' => $eleves,
        ]);
    }

    #[Route('/eleve/add', 'eleve.add', methods: ['GET', 'POST'])]
    #[Route('/eleve/{id}/update', name: 'update_eleve')]
    public function add(ManagerRegistry $doctrine, Eleve $eleve = null, Request $request) : Response
    {
        if(!$eleve){
            $eleve = New Eleve();
        }

        $form = $this->createForm(EleveType::class, $eleve);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $eleve = $form->getData();
            $entityManager = $doctrine->getManager();
            //(prepare selon PDO)
            $entityManager->persist($eleve);
            //insert into (execute selon PDO)
            $entityManager->flush();

            //redirection vers la route des eleves
            return $this->redirectToRoute('app_eleve');
        }

        //redirection vers la vue du Form
        return $this->render('eleve/add.html.twig', [
            'formAddEleve' => $form->createView(),
            'update'=> $eleve->getId()
        ]);
        
    }

    #[Route('/eleve/{id}/delete', name: 'delete_eleve')]
    public function delete( ManagerRegistry $doctrine, Eleve $eleve ):Response
    {
        $entityManager = $doctrine->getManager();

        $entityManager->remove($eleve);
        //persist pas utile, flush, execute requete
        $entityManager->flush();

        return $this->redirectToRoute('app_eleve');
    }

    //*details (toujours à mettre à la fon du Controller)
    #[Route('/eleve/{id}', name: 'show_eleve')]
    public function show( EleveRepository $eleveRepository, Eleve $eleve): Response 
    {
        $eleve_id = $eleve->getId();
    
        return $this->render('eleve/show.html.twig', [
            'eleve' => $eleve
        ]);
    }

//
}
