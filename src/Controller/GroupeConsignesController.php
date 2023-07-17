<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GroupeConsignesController extends AbstractController
{
    #[Route('/groupe/consignes', name: 'app_groupe_consignes')]
    public function index(): Response
    {
        return $this->render('groupe_consignes/index.html.twig', [
            'controller_name' => 'GroupeConsignesController',
        ]);
    }
}
