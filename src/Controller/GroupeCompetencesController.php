<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GroupeCompetencesController extends AbstractController
{
    #[Route('/groupe/competences', name: 'app_groupe_competences')]
    public function index(): Response
    {
        return $this->render('groupe_competences/index.html.twig', [
            'controller_name' => 'GroupeCompetencesController',
        ]);
    }
}
