<?php

namespace App\Security\Voter;
use App\Entity\Task;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class TaskVoter extends Voter
{
    public const DELETE = 'TASK_DELETE';

    public function __construct(private Security $security)
    {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::DELETE]) && $subject instanceof Task;
    }

    protected function voteOnAttribute(string $attribute, $task, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }
        return ($task->getAuthor() === null && $this->security->isGranted("ROLE_ADMIN")) || $user == $task->getAuthor();
    }
}