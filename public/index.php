<?php

use Slim\Factory\AppFactory;
use Storylog\Controllers\AuthController;
use Storylog\Controllers\BlogController;
use Storylog\Controllers\HomeController;
use Storylog\Controllers\CategoryController;

include __DIR__ . '/../bootstrap.php';

$container = require CONFIG_PATH . '/container/container.php';

AppFactory::setContainer($container);

$app = AppFactory::create();

$app->get('/', [HomeController::class, 'index']);
$app->get('/profile/edit', [HomeController::class, 'edit_profile']);
$app->get('/profile/{username}', [HomeController::class, 'profile']);

$app->get('/blog/create', [BlogController::class, 'create']);
$app->post('/blog/create', [BlogController::class, 'store']);
$app->get('/blog/edit', [BlogController::class, 'edit']);
$app->get('/blog/{blogname}', [BlogController::class, 'index']);

$app->get('/category/{category}', [CategoryController::class, 'category']);

$app->get('/login', [AuthController::class, 'login']);
$app->get('/register', [AuthController::class, 'register']);
$app->get('/logout', [AuthController::class, 'logout']);
$app->get('/forgot-password', [AuthController::class, 'forgotPassword']);

$app->run();