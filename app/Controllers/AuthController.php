<?php

namespace Storylog\Controllers;

use Storylog\Core\Controller;

class AuthController extends Controller
{
    public function login()
    {
        return $this->render('auth/login', [
            'title' => 'Login page',
            'name' => 'Henry'
        ]);
    }

    public function register()
    {
        return $this->render('auth/register', [
            'title' => 'Register page',
            'name' => 'Henry'
        ]);
    }

    public function forgotPassword()
    {
        return $this->render('auth/forgot-password', [
            'title' => 'Forgot password',
            'name' => 'Henry'
        ]);
    }

    public function logout()
    {
        return $this->render('auth/forgot-password', [
            'title' => 'Forgot password',
            'name' => 'Henry'
        ]);
    }
}