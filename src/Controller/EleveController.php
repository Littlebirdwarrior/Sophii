<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Form\EleveType;
use App\Repository\EleveRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function add(ManagerRegistry $doctrine, Eleve $eleve = null, Request $request) : Response
    {
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
            'formAddEleve' => $form->createView()
        ]);
        
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
