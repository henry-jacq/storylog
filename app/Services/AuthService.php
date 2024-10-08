<?php

namespace App\Services;

use DateTime;
use Exception;
use App\Entity\User;
use App\Core\Session;
use Doctrine\ORM\EntityManagerInterface;

class AuthService
{
    public function __construct(
        private readonly Session $session,
        private readonly UserService $user,
        private readonly EntityManagerInterface $em,
    ) {}

    /**
     * Login user with username or email
     */
    public function login(array $data)
    {

        $user = $this->user->getByUsername($data['username']);

        if ($user && password_verify($data['password'], $user->getPassword())) {
            $this->session->regenerate();
            $this->session->put('user', $user->getId());
            // $this->session->put('userSession', $session);
            return true;
        }

        return false;
    }

    /**
     * Logout user from the session
     */
    public function logout(): void
    {
        $this->session->forget('user');
        $this->session->forget('userData');
        $this->session->deleteCookie('session_token');
        $this->session->regenerate();
    }

    /**
     * Check if the user is logged in or not
     */
    public function isAuthenticated(): bool
    {
        if ($this->session->get('user') !== null) {
            return true;
        }
        return false;
    }
}
