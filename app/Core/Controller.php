<?php

namespace Storylog\Core;

use Storylog\Core\Application;


class Controller
{

    protected array $middlewares = [];

    public function render($view, $params = []): string
    {
        return Application::$app->view->createPage($view, $params);
    }

    // public function registerMiddleware(BaseMiddleware $middleware)
    // {
    //     $this->middlewares[] = $middleware;
    // }

    // public function getMiddlewares(): array
    // {
    //     return $this->middlewares;
    // }
}
