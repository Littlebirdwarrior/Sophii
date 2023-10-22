<?php

namespace App\Controller;
use App\Entity\Classe;
use App\Entity\Eleve;
use App\Entity\Image;
use App\Entity\User;
use App\Form\SearchType;
use App\Form\UpdateEnsType;
use App\Form\UpdateUserType;
use App\Model\SearchData;
use App\Repository\ClasseRepository;
use App\Repository\UserRepository;
use App\Service\ImageService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(ManagerRegistry $doctrine, UserRepository $userRepository, Request $request): Response
    {
        $users = $doctrine->getRepository( User::class)->findBy([], ["nom" => "ASC"]);

        $searchData = new SearchData();
        //attent les type et les data
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $users = $userRepository->findBySearch($searchData);
        }
        return $this->render('user/index.html.twig', [
            'form' => $form->createView(),
            'users' => $users,
        ]);
    }

    #[Route('/parents', name: 'app_parents')]
    public function listParents(ManagerRegistry $doctrine, UserRepository $userRepository, Request $request): Response
    {
        $parents = $doctrine->getRepository( User::class)->findParents();

        $searchData = new SearchData();
        //attent les type et les data
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $parents = $userRepository->findBySearch($searchData);
        }

        return $this->render('user/listParents.html.twig', [
            'form' => $form->createView(),
            'parents' => $parents,
        ]);
    }

    #[Route('/enseignants', name: 'app_enseignants')]
    public function listEns(ManagerRegistry $doctrine, UserRepository $userRepository, Request $request): Response
    {
        $enseignants = $doctrine->getRepository( User::class)->findEnseignants();

        $searchData = new SearchData();
        //attent les type et les data
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $enseignants = $userRepository->findBySearch($searchData);
        }

        return $this->render('user/listEns.html.twig', [
            'form' => $form->createView(),
            'enseignants' => $enseignants,
        ]);
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
    #[Route("/user/removeEnfant/{user}/{eleve}", name: 'remove_enfant')]

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
     * Updater info d'un parent
     * */

    #[Route('/user/{id}/update', name: 'update_user', methods: ['GET', 'POST'])]

    public function updateParent(ManagerRegistry $doctrine, User $user = null, Request $request, ImageService $imageService) : Response
    {

        if(!$user){
            return $this->redirectToRoute('app_register');
        }

        $form = $this->createForm(UpdateUserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            //recupérer les images
            $images = $form->get('image')->getData();

            foreach($images as $image){
                //on definis le dossier de destination
                $dossier = 'user';

                //On appelle le service d'ajout
                $fichier = $imageService->addThisImage($image, $dossier, 200,200);
                $img = new Image();
                $img->setNom($fichier);
                $user->addImage($img);
            }
            $user = $form->getData();
            $entityManager = $doctrine->getManager();
            //(prepare selon PDO)
            $entityManager->persist($user);
            //insert into (execute selon PDO)
            $entityManager->flush();
            //redirection vers la route des enseignants

        }

        //redirection vers la vue du Form
        return $this->render('user/update.html.twig', [
            'formUpdateUser' => $form->createView(),
            'update'=> $user->getId(),
            'user'=> $user
        ]);

    }

    /*
     * Updater info d'un enseignants
     * */

    /*
     * J'importe l'authorisation checker
     * */
    private AuthorizationCheckerInterface $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    #[Route('/user/{id}/update_ens', name: 'update_ens', methods: ['GET', 'POST'])]

    public function updateEns(ManagerRegistry $doctrine, User $user = null, Request $request, ImageService $imageService) : Response
    {
        if(!$user){
            return $this->redirectToRoute('app_register');
        }

        $isAdmin = $this->authorizationChecker->isGranted('ROLE_ADMIN');

        $form = $this->createForm(UpdateEnsType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            //recupérer les images
            $images = $form->get('image')->getData();

            foreach($images as $image){
                //on definis le dossier de destination
                $dossier = 'user';

                //On appelle le service d'ajout
                $fichier = $imageService->addThisImage($image, $dossier, 200,200);
                $img = new Image();
                $img->setNom($fichier);
                $user->addImage($img);
            }
            $user = $form->getData();
            $entityManager = $doctrine->getManager();
            //(prepare selon PDO)
            $entityManager->persist($user);
            //insert into (execute selon PDO)
            $entityManager->flush();
            //redirection vers la route des enseignants

        }

        //redirection vers la vue du Form
        return $this->render('user/updateEns.html.twig', [
            'formUpdateEns' => $form->createView(),
            'update'=> $user->getId(),
            'user'=> $user,
            'isAdmin' => $isAdmin,
        ]);

    }


    /*
     * Supprimer les images
     *
     * */

    #[Route('/user/delete_image/{id}', name: 'delete_image', methods:["DELETE", "GET"])]
    public function deleteImage(Image $image, Request $request, EntityManagerInterface $em, ImageService $imageService): Response
    {
        $user = $image->getUser();
        $nom = $image->getNom();

        $dossier = 'user';
        $imageService->deleteThisImage($nom, $dossier, 200, 200);
        $user->removeImage($image);
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('update_user', ['id' => $user->getId()]);
    }

    /**
     * Delete User
     * */
    #[Route('/user/{id}/delete', name: 'delete_user', methods: ['GET', 'POST'])]
    public function delete( ManagerRegistry $doctrine, User $user, ImageService $imageService):Response
    {
        $entityManager = $doctrine->getManager();

        // vérifier si la classe contient des enseignant avant de la supprimer.
        if (!$user->getImages()->isEmpty()) {
            // Supprimez les ens liés à la classe.
            foreach ($user->getImages() as $image) {
                $user->removeImage($image);
                /*$image->delete_image;*/ //ici, doit supprimer les image reliée à l'élève
                $imageService->deleteThisImage($image->getNom(), "user", 200, 200);
            }
        }

        $entityManager->remove($user);
        //persist pas utile, flush, execute requete
        $entityManager->flush();

        return $this->redirectToRoute('app_user');
    }

    /*
     * Updater les enfants rattachés au parents
     * */

    #[Route('/user/{id}/nonEnfant', name: 'show_nonEnfant')]
    public function updateEnfant(UserRepository $userRepository, User $user): Response
    {
        $user_id = $user->getId();

        // Récupérez les enfants
        $nonEnfants = $userRepository->getNonEnfant($user_id);

        return $this->render('user/nonEnfant.html.twig', [
            'user' => $user,
            'nonEnfants' => $nonEnfants,
        ]);
    }

    /**
     * Voir la classe d'un enseignant
     */
    #[Route('/user/{id}/showEnsClasse', name: 'show_ens_classe')]
    public function showEnsClasse(ManagerRegistry $doctrine, UserRepository $userRepository, User $user): Response
    {
        if (!$this->isGranted('ROLE_ENS') && !$this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Accès refusé. Vous devez être un enseignant ou un administrateur.');
        }

        $user_id = $user->getId();
        $classe_id = $user->getClasse();
        $classe = $doctrine->getManager()->find(Classe::class, $classe_id);
        $eleves = $classe->getEleves();
        $ens = $classe->getEnseignants();

        return $this->render('classe/show.html.twig', [
            'classe' => $classe,
            'ens' => $ens,
            'eleves' => $eleves
        ]);
    }


    /**
     * Voir le détail
     */
    #[Route('/user/{id}', name: 'show_user')]
    public function show(ManagerRegistry $doctrine, UserRepository $userRepository, User $user): Response
    {
        $user_id = $user->getId();
        //$classe_id = $user->getClasse()->getId();
        //$classe = $doctrine->getManager()->find(Classe::class, $classe_id);

        return $this->render('user/profil.html.twig', [
            'user' => $user,
            //'classe' => $classe
        ]);
    }
}
