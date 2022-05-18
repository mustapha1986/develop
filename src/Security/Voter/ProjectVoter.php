<?php

namespace App\Security\Voter;

use App\Entity\Project;
use App\Entity\Utilisateur;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class ProjectVoter extends Voter
{
    public const EDIT = 'edit';
    public const DELETE = 'delete';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof Project;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$subject instanceof Project) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                // logic to determine if the user can EDIT
                // return true or false
                return $this->canEdit($user , $subject);
                break;
            case self::DELETE:
                // logic to determine if the user can VIEW
                // return true or false
                return $this->canDelete($user , $subject);
                break;
        }

        return false;
    }


    public function canEdit(Utilisateur $user, Project $project): bool
    {
        return $user->hasRoles('ROLE_ADMIN') || $user === $project->getAuthor();
          
    }

    public function canDelete(Utilisateur $user, Project $project): bool
    {
        return $user->hasRoles('ROLE_ADMIN') || $user === $project->getAuthor();
    }
}
