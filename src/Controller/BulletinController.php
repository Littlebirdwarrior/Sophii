<?php

namespace App\Controller;

use App\Entity\Bulletin;
use App\Form\BulletinType;
use App\Repository\BulletinRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BulletinController extends AbstractController
{
    #[Route('/bulletin', name: 'app_bulletin')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $bulletins = $doctrine->getRepository( Bulletin::class)->findAll();
        return $this->render('bulletin/index.html.twig', [
            'bulletins' => $bulletins,
        ]);
    }

    #[Route('/bulletin/add/{id_eleve}', 'bulletin_add', methods: ['GET', 'POST'])]
    #[Route('/bulletin/{id}/update', name: 'update_classe')]
    public function add(ManagerRegistry $doctrine, Bulletin $bulletin = null, Request $request) : Response
    {
        $entityManager = $doctrine->getManager();

        if(!$bulletin){
            $bulletin = New Bulletin();
        }

        $form = $this->createForm(BulletinType::class, $bulletin);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $bulletin = $form->getData();
            $entityManager = $doctrine->getManager();
            //(prepare selon PDO)
            $entityManager->persist($bulletin);
            //insert into (execute selon PDO)
            $entityManager->flush();

            //redirection vers la route des classes
            return $this->redirectToRoute('app_bulletin');
        }

        //redirection vers la vue du Form
        return $this->render('bulletin/add.html.twig', [
            'formAddBulletin' => $form->createView(),
            'update' => $bulletin->getId()
        ]);

    }

    #[Route('/bulletin/{id}/delete', name: 'delete_bulletin')]
    public function delete( ManagerRegistry $doctrine, Bulletin $bulletin ):Response
    {
        $entityManager = $doctrine->getManager();

        $entityManager->remove($bulletin);
        //persist pas utile, flush, execute requete
        $entityManager->flush();

        return $this->redirectToRoute('app_bulletin');
    }

    //*details
    #[Route('/bulletin/{id}', name: 'show_bulletin')]
    public function show( BulletinRepository $bulletinRepository, Bulletin $bulletin): Response
    {
        $bulletin_id = $bulletin->getId();

        return $this->render('classe/show.html.twig', [
            'bulletin' => $bulletin,
        ]);
    }
}
