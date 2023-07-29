<?php

namespace Storylog\Controllers;

use Storylog\Core\Application;
use Storylog\Core\View;
use Storylog\Core\Controller;

class HomeController extends Controller
{
    // public function __construct(){}

    public function home()
    {
        return $this->render('home/home', [
            'title' => 'Home',
            'name' => 'Henry'
        ]);
    }

    public function blog()
    {
        $blogName = Application::$app->request->getRouteParam('blogname');
        return $this->render('home/blog', [
            'title' => 'Blog page',
            'blogname' => $blogName
        ]);
    }

    public function profile()
    {
        $username = Application::$app->request->getRouteParam('username');
        return $this->render('home/profile', [
            'title' => "Profile",
            'username' => $username
        ]);
    }
}