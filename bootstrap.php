<?php

use Dotenv\Dotenv;

include 'vendor/autoload.php';
include 'config/constants.php';
include 'config/helper.php';

$dotenv = Dotenv::createImmutable(APP_PATH);
$dotenv->load();
