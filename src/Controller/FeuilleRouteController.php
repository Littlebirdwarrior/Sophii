<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeuilleRouteController extends AbstractController
{
    #[Route('/feuille/route', name: 'app_feuille_route')]
    public function index(): Response
    {
        return $this->render('feuille_route/index.html.twig', [
            'controller_name' => 'FeuilleRouteController',
        ]);
    }
}
