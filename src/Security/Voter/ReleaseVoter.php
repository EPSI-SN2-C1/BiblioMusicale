<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class ReleaseVoter extends Voter
{
    public const EDIT = 'POST_EDIT';
    public const VIEW = 'POST_VIEW';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof \App\Entity\Release;
    }

    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute The attribute to check
     * @param mixed $subject The subject to secure
     * @param TokenInterface $token The security token
     * 
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // // ... (check conditions and return true to grant permission) ...
        // switch ($attribute) {
        //     case self::EDIT:
        //         // logic to determine if the user can EDIT
        //         // return true or false
        //         break;

        //     case self::VIEW:
        //         // logic to determine if the user can VIEW
        //         // return true or false
        //         break;
        // }

        if ($subject->getArtist()->getOwner() === $user) {
            return true;
        }

        return false;
    }
}
