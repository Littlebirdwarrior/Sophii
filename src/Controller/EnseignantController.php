<?php

namespace App\Controller;

use App\Entity\Enseignant;
use App\Repository\EnseignantRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EnseignantController extends AbstractController
{
    #[Route('/enseignant', name: 'app_enseignant')]
    public function index( ManagerRegistry $doctrine): Response
    {
        $enseignants = $doctrine->getRepository( Enseignant::class)->findBy([], ["nom" => "ASC"]);

        return $this->render('enseignant/index.html.twig', [
            'enseignants' => $enseignants,
        ]);
    }

    //*details
    #[Route('/enseignant/{id}', name: 'show_enseignant')]
    public function show( EnseignantRepository $enseignantRepository, Enseignant $enseignant): Response 
    {
        $enseignant_id = $enseignant->getId();

        return $this->render('enseignant/show.html.twig', [
            'enseignant' => $enseignant
        ]);
    }
}
