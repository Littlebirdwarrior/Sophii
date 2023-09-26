<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Entity\Image;
use App\Form\EleveType;
use App\Repository\EleveRepository;
use App\Service\ImageService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EleveController extends AbstractController
{
    #[Route('/eleve', name: 'app_eleve')]
    public function index( ManagerRegistry $doctrine ): Response
    {
        $eleves = $doctrine->getRepository( Eleve::class)->findBy([], ["nom" => "ASC"]);
        
        return $this->render('eleve/index.html.twig', [
            'eleves' => $eleves,
        ]);
    }

    /**
     * @throws \Exception
     */
    #[Route('/eleve/add', 'eleve.add', methods: ['GET', 'POST'])]
    #[Route('/eleve/{id}/update', name: 'update_eleve')]
    public function add(ManagerRegistry $doctrine, Eleve $eleve = null, Request $request, ImageService $imageService) : Response
    {
        if(!$eleve){
            $eleve = New Eleve();
        }

        $form = $this->createForm(EleveType::class, $eleve);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            //recupérer les images
            $images = $form->get('image')->getData();

            foreach($images as $image){
                //on definis le dossier de destination
                $dossier = 'eleves';

                //On appelle le service d'ajout
                $fichier = $imageService->addThisImage($image, $dossier, 200,200);
                $img = new Image();
                $img->setNom($fichier);
                $eleve->addImage($img);
            }

            $eleve = $form->getData();
            $entityManager = $doctrine->getManager();
            //(prepare selon PDO)
            $entityManager->persist($eleve);
            //insert into (execute selon PDO)
            $entityManager->flush();
            //redirection vers la route des eleves
            return $this->redirectToRoute('app_eleve');
        }

        //redirection vers la vue du Form
        return $this->render('eleve/add.html.twig', [
            'formAddEleve' => $form->createView(),
            'update'=> $eleve->getId(),
            'eleve' => $eleve
        ]);
        
    }

    #[Route('eleve/delete_image/{id}', name: 'eleve_delete_image')]
    public function deleteImage(ManagerRegistry $doctrine, Image $image, Eleve $eleve,
                                Request $request, ImageService $imageService) : Response
    {

        $entityManager = $doctrine->getManager();

        $eleve = $image->getEleve();
        $nom = $image->getNom();

        $imageService->deleteThisImage($nom, 'eleves', 200, 200);
        $eleve->removeImage($image);
        $entityManager->persist($eleve);
        $entityManager->flush();

        return $this->redirectToRoute('update_eleve', ['id' => $eleve->getId()]);
    }



    #[Route('/eleve/{id}/delete', name: 'delete_eleve')]
    public function delete( ManagerRegistry $doctrine, Eleve $eleve, ImageService $imageService ):Response
    {
        $entityManager = $doctrine->getManager();

        // vérifier si la classe contient des enseignant avant de la supprimer.
        if (!$eleve->getImages()->isEmpty()) {
            // Supprimez les ens liés à la classe.
            foreach ($eleve->getImages() as $image) {
                $eleve->removeImage($image);
                /*suppression des images dans le dossier upload*/
                $imageService->deleteThisImage($image->getNom(), "eleves", 200, 200);
            }
        }

        $entityManager->remove($eleve);
        //persist pas utile, flush, execute requete
        $entityManager->flush();

        return $this->redirectToRoute('app_eleve');
    }



    //*details (toujours à mettre à la fon du Controller)
    #[Route('/eleve/{id}', name: 'show_eleve')]
    public function show( EleveRepository $eleveRepository, Eleve $eleve): Response 
    {
        $eleve_id = $eleve->getId();
    
        return $this->render('eleve/show.html.twig', [
            'eleve' => $eleve
        ]);
    }

//
}
