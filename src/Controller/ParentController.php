<?php

namespace App\Controller;


use App\Entity\ParentEleve;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ParentController extends AbstractController
{
    #[Route('/parent', name: 'app_parent')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $parents = $doctrine->getRepository( ParentEleve::class)->findBy([], ["nom" => "ASC"]);

        return $this->render('parent/index.html.twig', [
            'parents' => $parents,
        ]);
    }
}
