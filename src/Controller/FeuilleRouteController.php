<?php

namespace App\Controller;

use App\Entity\FeuilleRoute;
use App\Form\FeuilleRouteType;
use App\Repository\FeuilleRouteRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FeuilleRouteController extends AbstractController
{
    #[Route('/feuille_route', name: 'app_feuille_route')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $feuille_routes = $doctrine->getRepository(FeuilleRoute::class)->findBy([],["semaine" => "DESC"]);


        return $this->render('feuille_route/index.html.twig', [
            'feuille_routes' => $feuille_routes,
        ]);
    }


    #[Route('/feuille_route/add', 'feuille_route.add', methods: ['GET', 'POST'])]
    #[Route('/feuille_route/{id}/update', name: 'update_feuille_route')]
    public function add(ManagerRegistry $doctrine, FeuilleRoute $feuille_route = null, Request $request): Response
    {
        if (!$feuille_route) {
            $feuille_route = new FeuilleRoute();
        }

        $form = $this->createForm(FeuilleRouteType::class, $feuille_route);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $feuille_route = $form->getData();
            $entityManager = $doctrine->getManager();
            //(prepare selon PDO)
            $entityManager->persist($feuille_route);
            //insert into (execute selon PDO)
            $entityManager->flush();

            //redirection vers la route des enseignants
            return $this->redirectToRoute('app_feuille_route');
        }

        //redirection vers la vue du Form
        return $this->render('feuille_route/add.html.twig', [
            'formAddFeuilleRoute' => $form->createView(),
            'update' => $feuille_route->getId()
        ]);

    }

    #[Route('/feuille_route/validerFeuilleRoute/{id}', name: 'valider_feuille_route')]
    public function validerFeuilleRoute(ManagerRegistry $doctrine, FeuilleRoute $feuille_route):Response
    {
        $validation = true;
        $entityManager = $doctrine->getManager();
        $feuille_route-> setValidation($validation);
        $entityManager->persist($feuille_route);
        $entityManager->flush();

        return $this->redirectToRoute('app_feuille_route');
    }

    #[Route('/feuille_route/devaliderFeuilleRoute/{id}', name: 'invalider_feuille_route')]
    public function invaliderFeuilleRoute(ManagerRegistry $doctrine, FeuilleRoute $feuille_route):Response
    {
        $validation = false;
        $entityManager = $doctrine->getManager();
        $feuille_route-> setValidation($validation);
        $entityManager->persist($feuille_route);
        $entityManager->flush();

        return $this->redirectToRoute('app_feuille_route');
    }

    #[Route('/feuille_route/{id}/delete', name: 'delete_feuille_route')]
    public function delete(ManagerRegistry $doctrine, FeuilleRoute $feuille_route): Response
    {
        $entityManager = $doctrine->getManager();

        $entityManager->remove($feuille_route);
        //persist pas utile, flush, execute requete
        $entityManager->flush();

        $feuille_routes = $doctrine->getRepository(FeuilleRoute::class)->findBy([]);

        return $this->render('feuille_route/index.html.twig', [
            'feuille_routes' => $feuille_routes,
        ]);
    }

    //*details
    #[Route('/feuille_route/{id}', name: 'show_feuille_route')]
    public function show(FeuilleRouteRepository $FeuilleRouteRepository, FeuilleRoute $feuille_route): Response
    {
        $feuille_route_id = $feuille_route->getId();

        return $this->render('feuille_route/show.html.twig', [
            'feuille_route' => $feuille_route
        ]);
    }
}

