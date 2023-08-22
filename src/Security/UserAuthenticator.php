<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

/*classe UserAuthenticator étend classe abstraite AbstractLoginFormAuthenticator de Symfony.
 utilisée pour gérer l'authentification des utilisateurs via un formulaire de connexion.*/
class UserAuthenticator extends AbstractLoginFormAuthenticator
{
    //trait en POO: unité de réutilisation de code (ajoute propriete et methode dans classe sans recours à héritage)
    //gère la redirection si une authentification réussie vers la page que l'utilisateur vise.
    use TargetPathTrait;

    //constante vers page de connexion
    public const LOGIN_ROUTE = 'app_login';

    //Le constructeur reçoit instance de UrlGeneratorInterface pour générer des URLs.
    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

    /*Cette méthode est responsable de l'authentification de l'utilisateur.
    Récupère les infos du formulaire ( l'email et le mot de passe) et crée un objet Passport qui encapsule ces infos.
    Le jeton CSRF (Cross-Site Request Forgery) généré ici.*/
    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');

        $request->getSession()->set(Security::LAST_USERNAME, $email);
        //depuis Symfony 5.3, gere le token CRSF (jeton de securité)
        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    /*Cette méthode est appelée lorsque l'authentification réussit. Elle gère la redirection après l'authentification.
    Si l'utilisateur avait une cible (page spécifique) à laquelle il souhaitait accéder avant d'être redirigé vers la page de connexion,
    il sera redirigé vers cette cible. Sinon, il sera redirigé vers le login.*/
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        //recupere la cible dans la session si elle existe et cible le bon pare-feu qui authorise la requête
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        //objet redirect Response (redirige à partir d'une url)
        return new RedirectResponse($this->urlGenerator->generate('app_login'));
        //Creation d'un fichier d'erreur
        throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
    }

    //retourne url du login si la methode demandée n'est pas authorisée
    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
