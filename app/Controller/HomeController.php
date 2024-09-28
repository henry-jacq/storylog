<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController extends BaseController
{
    public function index(Request $request, Response $response): Response
    {
        parent::addGlobals('appTheme', 'dark');
        $args = [
            'title' => 'Home',
        ];
        return parent::render($request, $response, 'user/home', $args);
    }
}
