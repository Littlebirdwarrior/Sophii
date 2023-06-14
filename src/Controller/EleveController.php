<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Repository\EleveRepository;
use Doctrine\Persistence\ManagerRegistry;
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

        //*details
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
