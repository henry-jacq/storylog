<?php

// Profile details
use App\Core\View;

View::renderLayout('header');
View::renderTemplate('templates/home/breadcrumb');
View::renderTemplate('templates/settings/index');
View::renderLayout('footer');
