<?php

namespace App\Controller;

use App\Entity\Eleve;
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

//
}
