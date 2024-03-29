<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Entity\Eleve;
use App\Entity\User;
use App\Form\ClasseType;
use App\Repository\ClasseRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


class ClasseController extends AbstractController
{
    /*
     * voir toutes les classes
     * */
    #[Route('/classe', name: 'app_classe')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $classes = $doctrine->getRepository( Classe::class)->findBy([], ["libelle" => "ASC"]);

        return $this->render('classe/index.html.twig', [
            'classes' => $classes
        ]);
    }

    /*
     * ajouter une classe les classes
     * */

    #[Route('/classe/add', 'classe.add', methods: ['GET', 'POST'])]
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
    public function delete( ManagerRegistry $doctrine, Classe $classe):Response
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

        // vérifier si la classe contient des enseignant avant de la supprimer.
        if (!$classe->getEnseignants()->isEmpty()) {
            // Supprimez les ens liés à la classe.
            foreach ($classe->getEnseignants() as $enseignant) {
                $classe->removeEnseignant($enseignant);
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

        return $this->redirectToRoute('nonEleveEns', ['id' => $classe->getId()]);
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

        return $this->redirectToRoute('nonEleveEns', ['id' => $classe->getId()]);
    }

    /**
     * Ajouter un enseignant de la liste d'un parent
     */
    #[Route("/classe/addEnseignant/{classe}/{enseignant}", name: 'add_ens')]

    public function addEnseignant(ManagerRegistry $doctrine, Classe $classe, User $enseignant)
    {
        $em = $doctrine->getManager();
        $classe-> addEnseignant($enseignant);
        $em->persist($classe);
        $em->flush();

        return $this->redirectToRoute('nonEleveEns', ['id' => $classe->getId()]);
    }

    /**
     * Supprimer un enseignant de la liste d'un parent
     */
    #[Route("/classe/removeEnseignant/{classe}/{enseignant}", name: 'remove_ens')]

    public function removeEnseignant(ManagerRegistry $doctrine, Classe $classe, User $enseignant)
    {
        $em = $doctrine->getManager();
        $classe->removeEnseignant($enseignant);
        $em->persist($classe);
        $em->flush();

        return $this->redirectToRoute('nonEleveEns', ['id' => $classe->getId()]);
    }

    #[Route('/classe/nonEleveEns/{id}', name: 'nonEleveEns')]
    public function updateEnfant(ClasseRepository $classeRepository, Classe $classe): Response
    {
        $classe_id = $classe->getId();

        $eleves = $classe->getEleves();

        $ens = $classe->getEnseignants();

        // Récupérez les enfants
        $nonEleves = $classeRepository->getNonEleve($classe_id);

        //récupérer les enseignants
        $nonEns = $classeRepository->getNonEns($classe_id);

        return $this->render('classe/listEleveEns.html.twig', [
            'classe' => $classe,
            'eleves' => $eleves,
            'ens' => $ens,
            'nonEleves' => $nonEleves,
            'nonEns' => $nonEns,
        ]);
    }


    /**
     *
     */
    #[Route('/show_ma_classe/{id}', name: 'show_ma_classe')]
    public function showMaClasse(ManagerRegistry $doctrine, TokenStorageInterface $tokenStorage, UserRepository $userRepository, ClasseRepository $classeRepository, Classe $classe): Response
    {
        $user = $tokenStorage->getToken()->getUser();

        if (!$user instanceof User) {
            // Gérer le cas où l'utilisateur n'est pas authentifié ou n'est pas un objet User
            // Redirection, message d'erreur, etc.
            // Par exemple :
            throw $this->createAccessDeniedException('Vous devez être connecté en tant qu\'enseignant pour accéder à cette page.');
        }

        $this->denyAccessUnlessGranted('ROLE_ENS');

        if ( $user->getClasse() !== $classe) {
            // Gérer le cas où l'utilisateur n'a pas le rôle "ROLE_ENS" ou n'appartient pas à la classe
            // Redirection, message d'erreur, etc.
            // Par exemple :
            throw $this->createAccessDeniedException('Vous n\'avez pas l\'autorisation d\'accéder à cette page.');
        } else {
            $classe_id = $user->getClasse()->getId();
        }

        $ens = $classe->getEnseignants();
        $eleves = $classe->getEleves();

        return $this->render('classe/show.html.twig', [
            'classe' => $classe,
            'ens' => $ens,
            'eleves'=>$eleves
        ]);
    }

    //*details
    #[Route('/classe/{id}', name: 'show_classe')]
    public function show( ClasseRepository $classeRepository, Classe $classe): Response 
    {
        $classe_id = $classe->getId();

        $eleves = $classe->getEleves();

        $ens = $classe->getEnseignants();

        return $this->render('classe/show.html.twig', [
            'classe' => $classe,
            'ens' => $ens,
            'eleves'=>$eleves
        ]);
    }
}
