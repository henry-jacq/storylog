<?php

use Dotenv\Dotenv;

include 'vendor/autoload.php';
include 'config/constants.php';
include 'config/functions.php';

$dotenv = Dotenv::createImmutable(APP_PATH);
$dotenv->load();

$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASS'],
    ]
];
