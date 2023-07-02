<?php

namespace App\Controller;

use App\Entity\Enseignant;
use App\Form\EnseignantType;
use App\Repository\EnseignantRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/enseignant/add', 'enseignant.add', methods: ['GET', 'POST'])]
    public function add(ManagerRegistry $doctrine, Enseignant $enseignant = null, Request $request) : Response
    {
        $form = $this->createForm(EnseignantType::class, $enseignant);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $enseignant = $form->getData();
            $entityManager = $doctrine->getManager();
            //(prepare selon PDO)
            $entityManager->persist($enseignant);
            //insert into (execute selon PDO)
            $entityManager->flush();

            //redirection vers la route des enseignant
            return $this->redirectToRoute('app_enseignant');
        }

        //redirection vers la vue du Form
        return $this->render('enseignant/add.html.twig', [
            'formAddEnseignant' => $form->createView()
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
