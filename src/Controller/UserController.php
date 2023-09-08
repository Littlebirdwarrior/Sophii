<?php

namespace App\Controller;
use App\Entity\Eleve;
use App\Entity\User;
use App\Form\UpdateUserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Query\Parameter;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $users = $doctrine->getRepository( User::class)->findBy([], ["nom" => "ASC"]);

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/parents', name: 'app_parents')]
    public function listParents(ManagerRegistry $doctrine): Response
    {
        $parents = $doctrine->getRepository( User::class)->findAll();

        return $this->render('user/listParents.html.twig', [
            'parents' => $parents,
        ]);
    }

    #[Route('/enseignants', name: 'app_enseignants')]
    public function listEns(ManagerRegistry $doctrine): Response
    {
        $enseignant = $doctrine->getRepository( User::class)->findAll();

        return $this->render('user/listEns.html.twig', [
            'enseignants' => $enseignant,
        ]);
    }


    #[Route('/user/{id}/delete', name: 'delete_user')]
    public function delete( ManagerRegistry $doctrine, User $user):Response
    {
        $entityManager = $doctrine->getManager();

        $entityManager->remove($user);
        //persist pas utile, flush, execute requete
        $entityManager->flush();

        return $this->redirectToRoute('app_user');
    }

    /**
     * Ajouter un eleve de la liste d'un parent
     */
    #[Route("/user/addEnfant/{user}/{eleve}", name: 'add_enfant')]

    public function addEnfant(ManagerRegistry $doctrine, User $user, Eleve $eleve)
    {
        $em = $doctrine->getManager();
        $user-> addElefe($eleve);
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('show_nonEnfant', ['id' => $user->getId()]);
    }

    /**
     * Supprimer un eleve de la liste d'un parent
     */
    #[Route("/session/removeEnfant/{user}/{eleve}", name: 'remove_enfant')]


    public function removeEnfant(ManagerRegistry $doctrine, User $user, Eleve $eleve)
    {
        $em = $doctrine->getManager();
        $user->removeElefe($eleve);
        // persist(entity) : dit à Doctrine de « persister » l'entité. Cela veut dire qu'à partir de maintenant cette entité (qui n'est qu'un simple objet !) est gérée par Doctrine. Cela n'exécute pas encore de requête SQL, ni rien d'autre.
        $em->persist($user);
        //exécuter effectivement les requêtes nécessaires pour sauvegarder les entités qu'on lui a dit de persister
        $em->flush();

        return $this->redirectToRoute('show_nonEnfant', ['id' => $user->getId()]);
    }


    /*
     * Updater info du parents
     * */

    #[Route('/user/{id}/user', name: 'update_user', methods: ['GET', 'POST'])]

    public function add(ManagerRegistry $doctrine, User $user = null, Request $request) : Response
    {
        if(!$user){
            return $this->redirectToRoute('app_register');
        }

        $form = $this->createForm(UpdateUserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $entityManager = $doctrine->getManager();
            //(prepare selon PDO)
            $entityManager->persist($user);
            //insert into (execute selon PDO)
            $entityManager->flush();
            //redirection vers la route des enseignants

            return $this->redirectToRoute('app_user');
        }

        //redirection vers la vue du Form
        return $this->render('user/update.html.twig', [
            'formUpdateUser' => $form->createView(),
            'update'=> $user->getId()
        ]);

    }

    /*
     * Updater les enfants rattachés au parents
     * */

    #[Route('/user/{id}', name: 'show_nonEnfant')]
    public function updateEnfant(UserRepository $userRepository, User $user): Response
    {
        $user_id = $user->getId();

        // Récupérez les enfants
        $nonEnfants = $userRepository->getNonEnfant($user_id);

        /*if (!empty($nonEnfants))
        {
            $countNE = count($nonEnfants);
        } else {
            $countNE = 0;
        }*/

        return $this->render('user/nonEnfant.html.twig', [
            'user' => $user,
            'nonEnfants' => $nonEnfants,
            //'countNE' => $countNE,
        ]);
    }

    /**
     * Voir le détail
     */
    #[Route('/user/{id}', name: 'show_user')]
    public function show(UserRepository $userRepository, User $user): Response
    {
        $user_id = $user->getId();

        return $this->render('user/profil.html.twig', [
            'user' => $user
        ]);
    }
}
