<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Form\ClasseType;
use App\Repository\ClasseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/classe/add', 'classe.add', methods: ['GET', 'POST'])]
    public function add(ManagerRegistry $doctrine, Classe $classe = null, Request $request) : Response
    {
        $form = $this->createForm(ClasseType::class, $classe);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $classe = $form->getData();
            $entityManager = $doctrine->getManager();
            //(prepare selon PDO)
            $entityManager->persist($classe);
            //insert into (execute selon PDO)
            $entityManager->flush();

            //redirection vers la route des eleves
            return $this->redirectToRoute('app_classe');
        }

        //redirection vers la vue du Form
        return $this->render('classe/add.html.twig', [
            'formAddClasse' => $form->createView()
        ]);
        
    }

    //*details
    #[Route('/classe/{id}', name: 'show_classe')]
    public function show( ClasseRepository $classeRepository, Classe $classe): Response 
    {
        $classe_id = $classe->getId();

        $eleves = $classe->getEleves();

        return $this->render('classe/show.html.twig', [
            'classe' => $classe,
            'eleves'=>$eleves
        ]);
    }
}
