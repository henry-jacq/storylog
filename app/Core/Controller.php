<?php

namespace Storylog\Core;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Controller
{
    public function __construct(private readonly View $view)
    {
    }
    
    public function render(Request $request, Response $response, string $viewPath, array $args)
    {
        $response->getBody()->write(
            (string) $this->view->createPage($viewPath, $args)
        );
        return $response;
    }

}
