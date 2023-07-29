<?php

namespace Storylog\Controllers;

use Storylog\Core\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthController extends Controller
{
    public function login(Request $request, Response $response): Response
    {
        $args = [
            'title' => 'Login page',
            'name' => 'Henry'
        ];
        return $this->render($request, $response, 'auth/login', $args);
    }

    public function register(Request $request, Response $response): Response
    {
        $args = [
            'title' => 'Register page',
            'name' => 'Henry'
        ];
        return $this->render($request, $response, 'auth/register', $args);
    }

    public function forgotPassword(Request $request, Response $response): Response
    {
        $args = [
            'title' => 'Forgot password',
            'name' => 'Henry'
        ];
        return $this->render($request, $response, 'auth/forgot-password', $args);
    }

    public function logout(Request $request, Response $response): Response
    {
        $args = [
            'title' => 'Forgot password',
            'name' => 'Henry'
        ];
        return $this->render($request, $response, 'auth/forgot-password', $args);
    }
}