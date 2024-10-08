<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthController extends BaseController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    public function login(Request $request, Response $response): Response
    {
        $args = [
            'title' => 'Login'
        ];
        return parent::render($request, $response, 'auth/login', $args);
    }

    public function validateLogin(Request $request, Response $response): Response
    {
        $email = $request->getParsedBody()['email'];
        $password = $request->getParsedBody()['password'];
        return $response;
    }
}
