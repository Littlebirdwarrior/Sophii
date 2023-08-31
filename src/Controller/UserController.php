<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\UpdateUserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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


    #[Route('/enseignant/{id}/user', name: 'update_user', methods: ['GET', 'POST'])]

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

    #[Route('/user/{id}/delete', name: 'delete_user')]
    public function delete( ManagerRegistry $doctrine, User $user):Response
    {
        $entityManager = $doctrine->getManager();

        $entityManager->remove($user);
        //persist pas utile, flush, execute requete
        $entityManager->flush();

        return $this->redirectToRoute('app_user');
    }

    #[Route('/user/{id}', name: 'show_user')]
    public function show(UserRepository $userRepository, User $user): Response
    {
        $user_id = $user->getId();

        return $this->render('user/show.html.twig', [
            'user' => $user
        ]);
    }
}
