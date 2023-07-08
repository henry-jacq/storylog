<?php

require 'vendor/autoload.php';

use App\Core\WebAPI;

$wp = new WebAPI();

$wp->initiateSession();