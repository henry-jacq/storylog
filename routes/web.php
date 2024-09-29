<?php

use Slim\App;
use App\Controller\ApiController;
use App\Controller\BaseController;
use App\Controller\HomeController;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->any('/', [HomeController::class, 'index']);
    $app->any('/journals', [HomeController::class, 'myJournals']);
    $app->any('/journal/create', [HomeController::class, 'createJournal']);
    $app->any('/settings', [HomeController::class, 'settings']);
    $app->any('/dashboard', [HomeController::class, 'dashboard']);
    $app->any('/profile', [HomeController::class, 'profile']);
    $app->any('/journal/edit/{id}', [HomeController::class, 'editJournal']);
    $app->any('/journal/{id}', [HomeController::class, 'showJournal']);

    $app->group('/static', function (RouteCollectorProxy $group) {
        $group->any('/{type}/{file}', [BaseController::class, 'getStatic']);
    });

    // API Routes
    $app->group('/api', function (RouteCollectorProxy $group) {
        $group->any('/{namespace}/{resource}[/{params:.*}]', [ApiController::class, 'process']);
    });
};
