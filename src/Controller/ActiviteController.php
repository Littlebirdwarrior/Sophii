<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Entity\Classe;
use App\Entity\Competence;
use App\Entity\GroupeCompetences;
use App\Entity\Image;
use App\Form\ActiviteType;
use App\Repository\ActiviteRepository;
use App\Service\ImageService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActiviteController extends AbstractController
{
    #[Route('/activite', name: 'app_activite')]
    public function index( ManagerRegistry $doctrine): Response
    {
        $activites = $doctrine->getRepository( Activite::class)->findBy([], ["titre" => "ASC"]);

        return $this->render('activite/index.html.twig', [
            'activites' => $activites,
        ]);
    }

    /*
     * Ajouter ou modifier une activite
     * */

    #[Route('/activite/add', name: 'activite.add', methods: ['GET', 'POST'])]
    #[Route('/activite/{id}/update', name: 'update_activite')]
    public function add(ManagerRegistry $doctrine, Activite $activite = null, Request $request, ImageService $imageService) : Response
    {
        $entityManager = $doctrine->getManager();

        if(!$activite){
            $activite = New Activite();
        }

        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            //recupérer les images
            $images = $form->get('image')->getData();

            foreach($images as $image){
                //on definis le dossier de destination
                $dossier = 'activite';

                //On appelle le service d'ajout
                $fichier = $imageService->addImage($image, $dossier, 450,450);
                $img = new Image();
                $img->setNom($fichier);
                $activite->addImage($img);
            }

            $activite = $form->getData();
            $entityManager = $doctrine->getManager();
            //(prepare selon PDO)
            $entityManager->persist($activite);
            //insert into (execute selon PDO)
            $entityManager->flush();

            //redirection vers la route des classes
            return $this->redirectToRoute('app_activite');
        }

        //redirection vers la vue du Form
        return $this->render('activite/add.html.twig', [
            'formAddActivite' => $form->createView(),
            'update' => $activite->getId(),
            'activite' => $activite
        ]);

    }

    /*
     * Supprimer les images
     *
     * */

    #[Route('delete_image/{id}', name: 'delete_image')]
    public function deleteImage(ManagerRegistry $doctrine, Image $image, Request $request, ImageService $imageService) : JsonResponse
    {
        //$this->denyAccessUnlessGranted('update_eleve', $eleve);
        $entityManager = $doctrine->getManager();

        // On récupère le contenu de la requête
        $data = json_decode($request->getContent(), true);

        if($this->isCsrfTokenValid('delete_image' . $image->getId(), $data['_token'])){
            // Le token csrf est valide
            // On récupère le nom de l'image
            $nom = $image->getNom();

            //dans un if car retourne un booleen
            if($imageService->deleteImage($nom, 'activite', 450, 450)){
                // On supprime l'image de la base de données
                $entityManager->remove($image);
                $entityManager->flush();

                return new JsonResponse(['success' => true], 200);
            }
            // La suppression a échoué
            return new JsonResponse(['error' => 'Erreur de suppression'], 400);
        }

        return new JsonResponse(['error' => 'Token invalide'], 400);
    }

    /*
     * Supprimer une activite
     * */
    #[Route('/activite/{id}/delete', name: 'delete_activite')]
    public function delete( ManagerRegistry $doctrine, Activite $activite):Response
    {
        $entityManager = $doctrine->getManager();

        //enlever les feuilles de routes
        if (!$activite->getGroupescompetences()->isEmpty()) {
            foreach ($activite->getGroupescompetences() as $groupescompetence) {
                $activite->removeGroupescompetence($groupescompetence);
            }
        }
        //enlever les feuilles d'activites
        if (!$activite->getFeuillesroute()->isEmpty()) {
            foreach ($activite->getFeuillesroute() as $feuillesroute) {
                $activite->removeFeuillesroute($feuillesroute);
            }
        }

        $entityManager->remove($activite);
        //persist pas utile, flush, execute requete
        $entityManager->flush();

        return $this->redirectToRoute('app_activite');
    }

    #[Route('/listCompetences/{id}', name: 'listCompetences')]
    public function updateListGroupeComp(ActiviteRepository $activiteRepository, Activite $activite): Response
    {
        $activite_id = $activite->getId();

        $listCompetences = $activiteRepository->getListGroupComp($activite_id);

        return $this->render('activite/listCompetences.html.twig', [
            'activite' => $activite,
            'listCompetences' => $listCompetences,
        ]);
    }

    /**
     * Ajouter un groupe de competence à une activité
     */
    #[Route("/user/addGroupeCompetence/{activite}/{groupescompetence}", name: 'add_groupeCompetence')]

    public function addGroupeCompetence(ManagerRegistry $doctrine, Activite $activite, GroupeCompetences $groupescompetence)
    {
        $em = $doctrine->getManager();
        $activite->addGroupescompetence($groupescompetence);
        $em->persist($activite);
        $em->flush();

        return $this->redirectToRoute('listCompetences', ['id' => $activite->getId()]);
    }

    /**
     * Supprimer un groupe de competence de la liste d'une activite
     */
    #[Route("/session/removeGroupeCompetence/{activite}/{groupescompetence}", name: 'remove_groupeCompetence')]


    public function removeGroupeCompetence(ManagerRegistry $doctrine, Activite $activite, GroupeCompetences $groupescompetence)
    {
        $em = $doctrine->getManager();
        $activite->removeGroupescompetence($groupescompetence);
        $em->persist($activite);
        $em->flush();

        return $this->redirectToRoute('listCompetences', ['id' => $activite->getId()]);
    }


//*details
    #[Route('/activite/{id}', name: 'show_activite')]
    public function show( ActiviteRepository $activiteRepository, Activite $activite): Response
    {
        $activite_id = $activite->getId();

        return $this->render('activite/show.html.twig', [
            'activite' => $activite
        ]);
    }

}
