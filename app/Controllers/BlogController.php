<?php

namespace Storylog\Controllers;

use Storylog\Core\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BlogController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $args = [
            'title' => 'Blog page',
            'blogname' => $request->getAttribute('blogname'),
        ];
        return $this->render($request, $response, 'blog/blog', $args);
    }

    public function create(Request $request, Response $response)
    {
        $args = [
            'title' => 'Create a Blog',
            'app_host' => $request->getHeader('host')[0],
            'request_proto' => $request->getServerParams()['HTTP_X_FORWARDED_PROTO']
        ];
        return $this->render($request, $response, 'blog/create', $args);
    }
}