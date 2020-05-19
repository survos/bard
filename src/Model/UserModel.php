<?php
namespace App\Model;

use App\Entity\User;
use KevinPapst\AdminLTEBundle\Model\UserInterface;

class UserModel implements UserInterface {
    /**
     * @var User
     */
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAvatar()
    {
        // TODO: Implement getAvatar() method.
    }

    public function getUsername()
    {
        return $this->user->getUsername();
        // TODO: Implement getUsername() method.
    }

    public function getName()
    {
        return $this->user->__toString();
        // TODO: Implement getName() method.
    }

    public function getMemberSince()
    {
        // TODO: Implement getMemberSince() method.
    }

    public function isOnline()
    {
        // TODO: Implement isOnline() method.
    }

    public function getIdentifier()
    {
        return $this->user->getId();
        // TODO: Implement getIdentifier() method.
    }

    public function getTitle()
    {
        return '';
        return $this->user->getTitle();
        // TODO: Implement getTitle() method.
    }
}