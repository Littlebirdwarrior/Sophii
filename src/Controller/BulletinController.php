<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BulletinController extends AbstractController
{
    #[Route('/bulletin', name: 'app_bulletin')]
    public function index(): Response
    {
        return $this->render('bulletin/index.html.twig', [
            'controller_name' => 'BulletinController',
        ]);
    }
}
