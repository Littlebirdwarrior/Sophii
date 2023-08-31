<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/*Pas de logique dans ce controller, contient deux méthodes, login et logout,
la logique est contenue dans le composant App Authenticator*/
class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // recupère l'erreur de login si elle existe
        $error = $authenticationUtils->getLastAuthenticationError();

        if(!$error) {
            // récuperer le dernier nom entré par l'utilisateur
            $lastUsername = $authenticationUtils->getLastUsername();
            $this->addFlash('success', 'Vous êtes connecté en tant que '. $lastUsername);
            return $this->render('security/login.html.twig', [
                'last_username' => $lastUsername,
            ]);
        } else {
            $this->addFlash('error', 'Vos identifiants ne sont pas valide');
            return $this->render('security/login.html.twig', [
                'error' => $error
            ]);
        }
    }

    //doit rester vide, est déjà gérée dans
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
