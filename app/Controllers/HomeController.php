<?php

namespace Storylog\Controllers;

use Storylog\Core\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController extends Controller
{
    public function index(Request $request, Response $response): Response
    {
        $args = [
            'title' => 'Home',
            'name' => 'Henry'
        ];
        return $this->render($response, 'home/home', $args);
    }

    public function profile(Request $request, Response $response)
    {
        $args = [
            'title' => 'Profile page',
            'username' => $request->getAttribute('username'),
        ];
        return $this->render($response, 'home/profile', $args);

    }

    public function edit_profile(Request $request, Response $response)
    {
        $args = [
            'title' => 'Edit Profile',
            'username' => $request->getAttribute('username'),
        ];
        return $this->render($response, 'home/edit-profile', $args);
    }
}
