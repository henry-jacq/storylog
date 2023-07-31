<?php

namespace Storylog\Controllers;

use Storylog\Core\View;
use Storylog\Model\User;
use Storylog\Core\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BlogController extends Controller
{
    public function __construct(
        private readonly View $view,
        private readonly User $user
    )
    {
        parent::__construct($view);
    }
    
    public function index(Request $request, Response $response)
    {
        $args = [
            'title' => 'Blog page',
            'blogname' => $request->getAttribute('blogname'),
        ];
        return $this->render($response, 'blog/blog', $args);
    }

    public function create(Request $request, Response $response)
    {
        $args = [
            'title' => 'Create a Blog',
            'app_host' => $request->getHeader('host')[0],
            'request_proto' => $request->getServerParams()['HTTP_X_FORWARDED_PROTO']
        ];
        return $this->render($response, 'blog/create', $args);
    }

    public function edit(Request $request, Response $response)
    {
        $args = [
            'title' => 'Edit Blog',
            'app_host' => $request->getHeader('host')[0],
            'request_proto' => $request->getServerParams()['HTTP_X_FORWARDED_PROTO']
        ];
        return $this->render($response, 'blog/edit', $args);
    }

    public function store(Request $request, Response $response)
    {
        // $request->getParsedBody(); // For getting the blog data

    }
}