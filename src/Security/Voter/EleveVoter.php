<?php

namespace App\Security\Voter;

use App\Entity\Eleve;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class EleveVoter extends Voter
{
    public const CREATE = 'POST_CREATE';

    public const UPDATE = 'POST_UPDATE';

    public const DELETE = 'POST_DELETE';
    public const VIEW = 'POST_VIEW';

    /* Function supports
    La méthode supports() permet de vérifier que le voter sera bien utilisé pour une entité précise et que l'attribut reçu est bien une des permissions que vous avez définies dans les constantes.
    @return = array des methode utilisée
         * */
    protected function supports(string $attribute, mixed $eleve): bool
    {

        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::CREATE, self::UPDATE, self::DELETE, self::VIEW])
            && $eleve instanceof Eleve;
    }
    /* Function supports
    La méthode voteOnAttribute() permet de vérifier que le user courant est bien le user connecté grâce à l'utilisation du token
    @return = array des methode utilisée,
         * */
    protected function voteOnAttribute(string $attribute, mixed $eleve, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if si l'user est anonyme, ne pas authorisé d'accès
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (vérifie les conditions et retourne true si permission authorisée) ...
        switch ($attribute) {
            case self::VIEW:
                //
                break;
            case self::CREATE:
                //
                break;
            case self::UPDATE:
                //
                break;
            case self::DELETE:
                //
                break;
        }

        return false;
    }
}


//https://writecode.fr/tutoriel/la-gestion-des-permissions-avec-les-voters
//https://github.com/symfony/symfony/blob/6.3/src/Symfony/Component/Form/Extension/Core/Type/EmailType.php