<?php

// Profile Page
use App\Core\User;
use App\Core\View;

if (isset($_GET['user']) && User::exists($_GET['user'])) {
    View::renderLayout('header');
    View::renderTemplate('templates/home/breadcrumb');
    View::renderTemplate('templates/home/profile');
    View::renderLayout('footer');
} else {
    View::loadErrorPage();
}
