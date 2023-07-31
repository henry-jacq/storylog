<?php

namespace Storylog\Core;

use Psr\Http\Message\ResponseInterface as Response;

class Controller
{
    public function __construct(
        private readonly View $view,
        private readonly Config $config
    )
    {
    }
    
    public function render(Response $response, string $viewPath, array $args)
    {
        $response->getBody()->write(
            (string) $this->view->createPage($viewPath, $args)
        );
        return $response;
    }

    public function writeAsJson(Response $response, array $payload)
    {
        $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}
