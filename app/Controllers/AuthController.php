<?php

namespace Storylog\Controllers;

use Storylog\Core\Auth;
use Storylog\Core\View;
use Storylog\Core\Config;
use Storylog\Core\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthController extends Controller
{
    public function __construct(
        private readonly View $view,
        private readonly Config $config,
        private readonly Auth $auth
    )
    {
        parent::__construct($view, $config);
    }
    
    public function login(Request $request, Response $response): Response
    {
        $args = [
            'title' => 'Login page'
        ];
        return $this->renderWithoutFrame($response, 'auth/login', $args);
    }

    public function register(Request $request, Response $response): Response
    {
        $args = [
            'title' => 'Register page'
        ];
        return $this->renderWithoutFrame($response, 'auth/register', $args);
    }

    public function store(Request $request, Response $response): Response
    {
        $data = [
            'username' => '',
            'fullname' => '',
            'password' => 'SuperSecretPassword',
            'email' => '@gmail.com',
            'active' => 0,
            'created_at' => now()
        ];
        // dd($this->user->create($data));
        return $this->respondAsJson($response, $data);
    }

    public function createUser(Request $request, Response $response): Response
    {
        return $response;
    }
    
    public function verifyLogin(Request $request, Response $response): Response
    {
        $result = $this->auth->login($request->getParsedBody());
        // if ($result !== false) {
        //     $data = ['message' => false];
        // }
        // $data = ['message' => true];
        // return $this->respondAsJson($response, $data);
        // return $response
        return $response->withHeader('Location', '/')->withStatus(302);
    }

    public function forgotPassword(Request $request, Response $response): Response
    {
        $args = [
            'title' => 'Forgot password',
            'name' => 'Henry'
        ];
        return $this->renderWithoutFrame($response, 'auth/forgot-password', $args);
    }

    public function logout(Request $request, Response $response): Response
    {
        $this->auth->logout();
        return $response->withHeader('Location', '/login')->withStatus(302);
    }
}