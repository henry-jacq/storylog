<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController extends BaseController
{
    public function index(Request $request, Response $response): Response
    {
        $userData = $request->getAttribute('userData');
        
        $args = [
            'title' => 'Home',
            'user' => $userData
        ];
        return parent::render($request, $response, 'user/home', $args);
    }

    public function myJournals(Request $request, Response $response): Response
    {
        $args = [
            'title' => 'My Journals',
        ];
        return parent::render($request, $response, 'user/manage', $args);
    }

    public function createJournal(Request $request, Response $response): Response
    {
        $args = [
            'title' => 'Create Journal',
        ];
        return parent::render($request, $response, 'user/create', $args);
    }
    
    public function settings(Request $request, Response $response): Response
    {
        $args = [
            'title' => 'Settings',
        ];
        return parent::render($request, $response, 'user/settings', $args);
    }

    public function profile(Request $request, Response $response): Response
    {
        $args = [
            'title' => 'My Profile',
        ];
        return parent::render($request, $response, 'user/profile', $args);
    }

    public function dashboard(Request $request, Response $response): Response
    {
        $args = [
            'title' => 'Dashboard',
        ];
        return parent::render($request, $response, 'user/dashboard', $args);
    }

    public function showJournal(Request $request, Response $response): Response
    {
        $args = [
            'title' => 'Journal',
            'id' => $request->getAttribute('id'),
        ];
        return parent::render($request, $response, 'user/journal', $args);
    }

    public function onboarding(Request $request, Response $response): Response
    {
        $args = [
            'title' => 'Onboarding'
        ];
        return parent::render($request, $response, 'user/onboarding', $args);
    }
}
