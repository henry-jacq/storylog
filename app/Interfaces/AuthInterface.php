<?php

namespace Storylog\Interfaces;


interface AuthInterface
{
    public function register($username, $fullname, $email, $password);

    public function login(array $credentials);

    public function checkCredentials(array $user, array $credentials): bool;

    public function logout(): void;
}
