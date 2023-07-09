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
    Vérifie que les méthodes précisées en attribue sont bien autorisée dans l'application
    @return = array des methode utilisée
         * */
    protected function supports(string $attribute, mixed $subject): bool
    {

        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::CREATE, self::UPDATE, self::DELETE, self::VIEW])
            && $subject instanceof Eleve;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::VIEW:
                // logic to determine if the user can EDIT
                // return true or false
                break;
            case self::CREATE:
                // logic to determine if the user can EDIT

                break;
            case self::UPDATE:
                //
                break;
            case self::DELETE:

                break;
        }

        return false;
    }
}


//https://writecode.fr/tutoriel/la-gestion-des-permissions-avec-les-voters
//https://github.com/symfony/symfony/blob/6.3/src/Symfony/Component/Form/Extension/Core/Type/EmailType.php