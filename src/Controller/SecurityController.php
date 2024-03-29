<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

/*Pas de logique dans ce controller, contient deux méthodes, login et logout,
la logique est contenue dans le composant App Authenticator*/
class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
         if ($this->getUser()) {
            return $this->redirectToRoute('');
        }
        // recupère l'erreur de login si elle existe
        $error = $authenticationUtils->getLastAuthenticationError();

        // récuperer le dernier nom entré par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        if($error) {
            $this->addFlash('error', 'Vos identifiants ne sont pas valide');
        }

        // Vérifiez le champ honeypot
        $honeypot = $request->request->get('honeypot');

        if (!empty($honeypot)) {
            // Vous pouvez prendre des mesures ici, par exemple, jeter une exception
            throw new CustomUserMessageAuthenticationException('Bot détecté !');
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    //doit rester vide, est déjà gérée dans
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        //throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
