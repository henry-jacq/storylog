<?php

use Slim\App;
use App\Controller\HomeController;
use App\Controller\BaseController;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->any('/', [HomeController::class, 'index']);

    $app->group('/static', function (RouteCollectorProxy $group) {
        $group->any('/{type}/{file}', [BaseController::class, 'getStatic']);
    });

    // API Routes
    $app->group('/api', function (RouteCollectorProxy $group) {
        $group->any('/{namespace}/{resource}[/{params:.*}]', [ApiController::class, 'process']);
    });
};
