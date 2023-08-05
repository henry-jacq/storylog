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

    /**
     * Write response as JSON
     */
    public function respondAsJson(Response $response, array $payload)
    {
        $statusCode = ($payload['message'] == false) ? 400 : 200;
        $response->getBody()->write(packJson($payload));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($statusCode);
    }
}
