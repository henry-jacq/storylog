<?php

namespace Storylog\Interfaces;


interface AuthInterface
{
    public function register(array $credentials);

    public function login(array $credentials);

    public function logout(): void;
}
