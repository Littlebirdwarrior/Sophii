<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Entity\Eleve;
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

    #[Route('/classe/add', 'classe_add', methods: ['GET', 'POST'])]
    #[Route('/classe/{id}/update', name: 'update_classe')]
    public function add(ManagerRegistry $doctrine, Classe $classe = null, Request $request) : Response
    {
        $entityManager = $doctrine->getManager();

        if(!$classe){
            $classe = New Classe();
        }

        $form = $this->createForm(ClasseType::class, $classe);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $classe = $form->getData();
            $entityManager = $doctrine->getManager();
            //(prepare selon PDO)
            $entityManager->persist($classe);
            //insert into (execute selon PDO)
            $entityManager->flush();

            //redirection vers la route des classes
            return $this->redirectToRoute('app_classe');
        }

        //redirection vers la vue du Form
        return $this->render('classe/add.html.twig', [
            'formAddClasse' => $form->createView(),
            'update' => $classe->getId()
        ]);
        
    }

    #[Route('/classe/{id}/delete', name: 'delete_classe')]
    public function delete( ManagerRegistry $doctrine, Classe $classe, Eleve $eleve ):Response
    {
        $entityManager = $doctrine->getManager();

        // vérifier si la classe contient des élèves avant de la supprimer.
        if (!$classe->getEleves()->isEmpty()) {
            // Supprimez les élèves liés à la classe.
            foreach ($classe->getEleves() as $eleve) {
                $classe->removeElefe($eleve);
                // pas besoin de définir le côté propriétaire à null car cela est géré par Doctrine.
            }
        }

        $entityManager->remove($classe);
        //persist pas utile, flush, execute requete
        $entityManager->flush();

        return $this->redirectToRoute('app_classe');
    }

    /**
     * Ajouter un eleve de la liste d'un parent
     */
    #[Route("/classe/addEleve/{classe}/{eleve}", name: 'add_eleve')]

    public function addEnfant(ManagerRegistry $doctrine, Classe $classe, Eleve $eleve)
    {
        $em = $doctrine->getManager();
        $classe-> addElefe($eleve);
        $em->persist($classe);
        $em->flush();

        return $this->redirectToRoute('show_nonEleve', ['id' => $classe->getId()]);
    }

    /**
     * Supprimer un eleve de la liste d'un parent
     */
    #[Route("/classe/removeEleve/{classe}/{eleve}", name: 'remove_eleve')]

    public function removeEleve(ManagerRegistry $doctrine, Classe $classe, Eleve $eleve)
    {
        $em = $doctrine->getManager();
        $classe->removeElefe($eleve);
        $em->persist($classe);
        $em->flush();

        return $this->redirectToRoute('show_nonEleve', ['id' => $classe->getId()]);
    }

    #[Route('/classe/{id}', name: 'show_nonEleve')]
    public function updateEnfant(ClasseRepository $classeRepository, Classe $classe): Response
    {
        $classe_id = $classe->getId();

        $eleves = $classe->getEleves();

        // Récupérez les enfants
        $nonEleves = $classeRepository->getNonEleve($classe_id);

        return $this->render('classe/listEleve.html.twig', [
            'classe' => $classe,
            'eleves' => $eleves,
            'nonEleves' => $nonEleves,
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
