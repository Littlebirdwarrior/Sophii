<?php

namespace App\Controller;

use App\Entity\Consigne;
use App\Repository\ConsigneRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConsigneController extends AbstractController
{
    #[Route('/consigne', name: 'app_consigne')]
    public function index( ManagerRegistry $doctrine): Response
    {
        $consignes = $doctrine->getRepository( Consigne::class)->findBy([], ["libelle" => "ASC"]);

        return $this->render('consigne/index.html.twig', [
            'consignes' => $consignes,
        ]);
    }

//*details
    #[Route('/consigne/{id}', name: 'show_consigne')]
    public function show( ConsigneRepository $consigneRepository, Consigne $consigne): Response
    {
        $consigne_id = $consigne->getId();

        return $this->render('consigne/show.html.twig', [
            'consigne' => $consigne
        ]);
    }

}
