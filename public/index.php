<?php

require '../bootstrap.php';

use App\Core\View;
use App\Core\Session;

if (isset($_GET['logout'])) {
    Session::logout(Session::get('session_token'));
    header("Location: /");
    die();
} else {
    View::renderPage();
}
