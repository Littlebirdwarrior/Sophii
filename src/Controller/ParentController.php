<?php

namespace App\Controller;


use App\Entity\ParentEleve;
use App\Form\ParentEleveType;
use App\Repository\ParentEleveRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/parent/add', 'parent.add', methods: ['GET', 'POST'])]
    #[Route('/parent/{id}/update', name: 'update_parent')]
    public function add(ManagerRegistry $doctrine, ParentEleve $parentEleve = null, Request $request) : Response
    {
        if(!$parentEleve){
            $parentEleve = New ParentEleve();
        }

        $form = $this->createForm(ParentEleveType::class, $parentEleve );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $parentEleve = $form->getData();
            $entityManager = $doctrine->getManager();
            //(prepare selon PDO)
            $entityManager->persist($parentEleve);
            //insert into (execute selon PDO)
            $entityManager->flush();

            //redirection vers la route des parentEleve
            return $this->redirectToRoute('app_parent');
        }

        //redirection vers la vue du Form
        return $this->render('parent/add.html.twig', [
            'formAddParent' => $form->createView(),
            'update'=> $parentEleve->getId()
        ]);
        
    }

    #[Route('/parent/{id}/delete', name: 'delete_parent')]
    public function delete( ManagerRegistry $doctrine, ParentEleve $parentEleve ):Response
    {
        $entityManager = $doctrine->getManager();
        //enleve le parent de la liste des parents
        $entityManager->remove($parentEleve);
        //persist pas utile, flush, execute requete
        $entityManager->flush();

        return $this->redirectToRoute('app_parent');
    }

    //*details
    #[Route('/parent/{id}', name: 'show_parent')]
    public function show(ParentEleveRepository $parentEleveRepository, ParentEleve $parentEleve): Response 
    {
        $parent_id = $parentEleve->getId();

        return $this->render('parent/show.html.twig', [
            'parent' => $parentEleve
        ]);
    }
}
