<?php

namespace Storylog\Controllers;

use Storylog\Core\View;
use Storylog\Core\Config;
use Storylog\Core\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BlogController extends Controller
{
    public function __construct(
        private readonly View $view,
        private readonly Config $config
    )
    {
        parent::__construct($view, $config);
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
            'app_host' => $this->config->get('app.host')
        ];
        return $this->render($response, 'blog/create', $args);
    }

    public function edit(Request $request, Response $response)
    {
        $args = [
            'title' => 'Edit Blog',
            'app_host' => $this->config->get('app.host')
        ];
        return $this->render($response, 'blog/edit', $args);
    }

    public function store(Request $request, Response $response)
    {
        dd($request->getUploadedFiles());
    }
}