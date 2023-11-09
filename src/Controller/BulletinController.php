<?php

namespace App\Controller;

use App\Entity\Bulletin;
use App\Entity\BulletinGroupeCompetences;
use App\Entity\Eleve;
use App\Entity\GroupeCompetences;
use App\Form\BulletinType;
use App\Repository\BulletinGroupeCompetencesRepository;
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
        $bulletins = $doctrine->getRepository( Bulletin::class)->findBy([], ["trimestre" => "ASC"]);

        return $this->render("bulletin/index.html.twig", [
            'bulletins' => $bulletins
        ]);
    }

    #[Route('/bulletin/add/{id_eleve}', 'bulletin_add', methods: ['GET', 'POST'])]
    #[Route('/bulletin/{id}/update', name: 'update_bulletin')]
    public function add(ManagerRegistry $doctrine, Bulletin $bulletin = null, Request $request, $id_eleve) : Response
    {
        $entityManager = $doctrine->getManager();

        if(is_null($bulletin)){
            $bulletin = New Bulletin();
        }

        $form = $this->createForm(BulletinType::class, $bulletin);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $bulletin = $form->getData();
            $entityManager = $doctrine->getManager();

            //je definis mon élève
            // Utilisez le gestionnaire de doctrine pour récupérer l'entité élève
            $eleve = $entityManager->getRepository(Eleve::class)->find($id_eleve);

            // Vérifiez si l'élève existe
            if (!$eleve) {
                throw $this->createNotFoundException('Le bulletin ne peut être crée car l\'élève avec l\'ID ' . $id_eleve . ' n\'a pas été trouvé.');
            }

            // Définissez l'élève associé au bulletin
            $bulletin->setEleve($eleve);

            //je definis ma date automatiquement
            $timeZone = new \DateTimeZone('Europe/Paris');
            $date = new \DateTime('now', $timeZone);
            $bulletin->setDate($date);

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

        // vérifier si la classe contient des enseignant avant de la supprimer.
        if (!$bulletin->getBulletinGroupeCompetences()->isEmpty()) {
            // Supprimez les ens liés à la classe.
            foreach ($bulletin->getBulletinGroupeCompetences() as $bulletinGroupeCompetence) {
                $bulletin->removeBulletinGroupeCompetence($bulletinGroupeCompetence);
                // pas besoin de définir le côté propriétaire à null car cela est géré par Doctrine.
            }
        }

        $entityManager->remove($bulletin);
        //persist pas utile, flush, execute requete
        $entityManager->flush();

        return $this->redirectToRoute('app_bulletin');
    }

    //*details--> voir l'entité bulletinGroupeCompetences
    #[Route('/bulletin/{id}', name: 'show_bulletin')]
    public function showBulletin($id, BulletinRepository $bulletinRepository): Response
    {
        // Récupérer le bulletin en fonction de l'ID passé en paramètre
        $bulletin = $bulletinRepository->find($id);

        // Vérifier si le bulletin a été trouvé
        if (!$bulletin) {
            throw $this->createNotFoundException('Bulletin non trouvé');
        }

        $eleve = $bulletin->getEleve();

        return $this->render('bulletin/show.html.twig', [
            'bulletin' => $bulletin,
            "eleve" => $eleve
        ]);
    }
}
