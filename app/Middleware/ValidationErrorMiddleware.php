<?php

namespace Storylog\Middleware;

use Storylog\Core\View;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;


class ValidationErrorMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly View $view
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (! empty($_SESSION['errors'])) {
            $this->view->addGlobals('errors', $_SESSION['errors']);
        }

        return $handler->handle($request);
    }
}
