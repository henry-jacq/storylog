<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthController extends BaseController
{
    public function login(Request $request, Response $response): Response
    {
        $args = [
            'title' => 'Login'
        ];
        return parent::render($request, $response, 'auth/login', $args);
    }
}
