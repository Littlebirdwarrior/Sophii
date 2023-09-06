<?php

namespace dump;

use App\Form\FamilleType;
use App\Repository\FamilleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FamilleController extends AbstractController
{
    #[Route('/famille', name: 'app_famille')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $familles = $doctrine->getRepository( Famille::class)->findBy([], ["nom" => "ASC"]);

        return $this->render('famille/index.html.twig', [
            'familles' => $familles,
        ]);
    }

    #[Route('/famille/add', 'famille.add', methods: ['GET', 'POST'])]
    #[Route('/famille/{id}/update', name: 'update_famille')]
    public function add(ManagerRegistry $doctrine, Famille $famille = null, Request $request) : Response
    {
        if(!$famille){
            $famille = New Famille();
        }

        $form = $this->createForm(FamilleType::class, $famille);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $famille = $form->getData();
            $entityManager = $doctrine->getManager();
            //(prepare selon PDO)
            $entityManager->persist($famille);
            //insert into (execute selon PDO)
            $entityManager->flush();

            //redirection vers la route des eleves
            return $this->redirectToRoute('app_famille');
        }

        //redirection vers la vue du Form
        return $this->render('famille/add.html.twig', [
            'formAddFamille' => $form->createView(),
            'update'=> $famille->getId()
        ]);

    }

    #[Route('/famille/{id}/delete', name: 'delete_famille')]
    public function delete( ManagerRegistry $doctrine, Famille $famille ):Response
    {
        $entityManager = $doctrine->getManager();

        $entityManager->remove($famille);
        //persist pas utile, flush, execute requete
        $entityManager->flush();

        return $this->redirectToRoute('app_famille');
    }

    //*details (toujours à mettre à la fon du Controller)
    #[Route('/famille/{id}', name: 'show_famille')]
    public function show( FamilleRepository $familleRepository, Famille $famille): Response
    {
        $famille_id = $famille->getId();

        return $this->render('famille/show.html.twig', [
            'famille' => $famille
        ]);
    }
}
