<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Entity\FeuilleRoute;
use App\Entity\GroupeCompetences;
use App\Entity\Image;
use App\Form\FeuilleRouteType;
use App\Repository\FeuilleRouteRepository;
use App\Service\ImageService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FeuilleRouteController extends AbstractController
{
    #[Route('/feuille_route', name: 'app_feuille_route')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $feuilleRoutes = $doctrine->getRepository(FeuilleRoute::class)->findBy([]);

        return $this->render('feuille_route/index.html.twig', [
            'feuilleRoutes' => $feuilleRoutes,
        ]);
    }


    /**
     * @throws \Exception
     */
    #[Route('/feuille_route/add', 'feuille_route.add', methods: ['GET', 'POST'])]
    #[Route('/feuille_route/{id}/update', name: 'update_feuille_route')]
    public function add(ManagerRegistry $doctrine, FeuilleRoute $feuilleRoute = null, Request $request, ImageService $imageService): Response
    {
        if (!$feuilleRoute) {
            $feuilleRoute = new FeuilleRoute();
        }

        $form = $this->createForm(FeuilleRouteType::class, $feuilleRoute);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //recupérer les images
            $images = $form->get('image')->getData();

            foreach($images as $image){
                //on definis le dossier de destination
                $dossier = 'feuilleRoute';

                //On appelle le service d'ajout
                $fichier = $imageService->addThisImage($image, $dossier, 450,450);
                $img = new Image();
                $img->setNom($fichier);
                $feuilleRoute->addImage($img);
            }

            $feuilleRoute = $form->getData();
            $entityManager = $doctrine->getManager();
            //(prepare selon PDO)
            $entityManager->persist($feuilleRoute);
            //insert into (execute selon PDO)
            $entityManager->flush();

            //redirection vers la route des enseignants
            return $this->redirectToRoute('app_feuille_route');
        }

        //redirection vers la vue du Form
        return $this->render('feuille_route/add.html.twig', [
            'formAddFeuilleRoute' => $form->createView(),
            'update' => $feuilleRoute->getId(),
            'feuilleRoute' => $feuilleRoute
        ]);

    }

    #[Route('/feuille_route/delete_image/{id}', name: 'delete_image')]
    public function deleteImage(ManagerRegistry $doctrine, Image $image, Request $request, ImageService $imageService) : Response
    {
        $entityManager = $doctrine->getManager();
        $feuilleRoute = $image->getFeuilleRoute();
        $nom = $image->getNom();

        $dossier = 'feuilleRoute';
        $imageService->deleteThisImage($nom, $dossier, 200, 200);
        $feuilleRoute->removeImage($image);
        $entityManager->persist($feuilleRoute);
        $entityManager->flush();

        return $this->redirectToRoute('update_feuille_route', ['id' => $feuilleRoute->getId()]);

    }


    /*
     * Activites rattachée à la feuille de route
     * */

    #[Route('/feuille_route/{id}/listActivite', name: 'list_activite')]
    public function listActivite(FeuilleRouteRepository $feuilleRouteRepository, FeuilleRoute $feuilleRoute): Response
    {
        $feuille_route_id = $feuilleRoute->getId();

        // Récupérez les enfants
        $nonActivite = $feuilleRouteRepository->getNonActivite($feuille_route_id);

        return $this->render('feuille_route/listActivite.html.twig', [
            'feuilleRoute' => $feuilleRoute,
            'nonActivite' => $nonActivite,
        ]);
    }

    /**
     * Ajouter une activite de la feuille de route
     */
    #[Route("/feuille_route/addActivite/{feuilleRoute}/{activite}", name: 'add_activite')]

    public function addActivite(ManagerRegistry $doctrine, FeuilleRoute $feuilleRoute, Activite $activite ): Response
    {
        $em = $doctrine->getManager();
        $feuilleRoute-> addActivite($activite);
        $em->persist($feuilleRoute);
        $em->flush();

        return $this->redirectToRoute('list_activite', ['id' => $feuilleRoute->getId()]);
    }

    /**
     * Supprimer une activite de la feuille de route
     */
    #[Route("/feuille_route/removeActivite/{feuilleRoute}/{activite}", name: 'remove_activite')]

    public function removeActivite(ManagerRegistry $doctrine, FeuilleRoute $feuilleRoute, Activite $activite ): Response
    {
        $em = $doctrine->getManager();
        $feuilleRoute-> removeActivite($activite);
        $em->persist($feuilleRoute);
        $em->flush();

        return $this->redirectToRoute('list_activite', ['id' => $feuilleRoute->getId()]);
    }

    /*
     * Valider une feuille de route
     *
     * */
    #[Route('/feuille_route/validerFeuilleRoute/{id}', name: 'valider_feuille_route')]
    public function validerFeuilleRoute(ManagerRegistry $doctrine, FeuilleRoute $feuilleRoute):Response
    {
        $validation = true;
        $entityManager = $doctrine->getManager();
        $feuilleRoute-> setValidation($validation);
        $entityManager->persist($feuilleRoute);
        $entityManager->flush();

        return $this->redirectToRoute('app_feuille_route');
    }

    #[Route('/feuille_route/devaliderFeuilleRoute/{id}', name: 'invalider_feuille_route')]
    public function invaliderFeuilleRoute(ManagerRegistry $doctrine, FeuilleRoute $feuilleRoute):Response
    {
        $validation = false;
        $entityManager = $doctrine->getManager();
        $feuilleRoute-> setValidation($validation);
        $entityManager->persist($feuilleRoute);
        $entityManager->flush();

        return $this->redirectToRoute('app_feuille_route');
    }

    #[Route('/feuille_route/{id}/delete', name: 'delete_feuille_route')]
    public function delete(ManagerRegistry $doctrine, FeuilleRoute $feuilleRoute): Response
    {
        $entityManager = $doctrine->getManager();

        // supprimer des image
        if (!$feuilleRoute->getImages()->isEmpty()) {
            // Supprimez les ens liés à la classe.
            foreach ($feuilleRoute->getImages() as $image) {
                $feuilleRoute->removeImage($image);
                /*$image->delete_image;*/ //ici, doit supprimer les image reliée à l'élève
            }
        }

        $entityManager->remove($feuilleRoute);
        //persist pas utile, flush, execute requete
        $entityManager->flush();

        $feuilleRoutes = $doctrine->getRepository(FeuilleRoute::class)->findBy([]);

        return $this->render('feuille_route/index.html.twig', [
            'feuilleRoutes' => $feuilleRoutes,
        ]);
    }

    //*details
    #[Route('/feuille_route/{id}', name: 'show_feuille_route')]
    public function show(FeuilleRouteRepository $FeuilleRouteRepository, FeuilleRoute $feuilleRoute): Response
    {
        $feuilleRoute_id = $feuilleRoute->getId();

        return $this->render('feuille_route/show.html.twig', [
            'feuilleRoute' => $feuilleRoute
        ]);
    }
}

