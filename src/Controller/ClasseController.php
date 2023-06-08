<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Repository\ClasseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClasseController extends AbstractController
{
    #[Route('/classe', name: 'app_classe')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $classes = $doctrine->getRepository( Classe::class)->findBy([], ["id" => "ASC"]);
        
        return $this->render('classe/index.html.twig', [
            'classes' => $classes
        ]);
    }

    //*details
    #[Route('/intern/{id}', name: 'show_classe')]
    public function show( ClasseRepository $classeRepository, Classe $classe): Response 
    {
        $classe_id = $classe->getId();

        $sessionsLeft = $classeRepository->getSessionLeft($classe_id);

        return $this->render('classe/show.html.twig', [
            'classe' => $classe
        ]);
    }
}
