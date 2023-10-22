<?php

namespace Storylog\Controllers;

use Storylog\Core\View;
use Storylog\Core\Config;
use Storylog\Core\Controller;
use Storylog\Services\BlogService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController extends Controller
{
    public function __construct(
        private readonly View $view,
        private readonly Config $config,
        private readonly BlogService $blog
    ) {
        parent::__construct($view, $config);
    }
    
    public function index(Request $request, Response $response): Response
    {        
        $blogs = $this->blog->getAllBlogs();

        $args = [
            'title' => 'Home',
            'blogs' => $blogs
        ];
        return $this->render($response, 'home/home', $args);
    }

    public function profile(Request $request, Response $response)
    {
        $args = [
            'title' => 'Profile page',
            'username' => $request->getAttribute('username'),
            'userData' => $request->getAttribute('userData')
        ];
        return $this->render($response, 'home/profile', $args);

    }

    public function edit_profile(Request $request, Response $response)
    {
        $args = [
            'title' => 'Edit Profile',
            'username' => $request->getAttribute('username'),
        ];
        return $this->render($response, 'home/edit-profile', $args);
    }
}
