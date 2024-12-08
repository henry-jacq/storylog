<?php

namespace App\Controller;

use DateTime;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController extends BaseController
{
    public function index(Request $request, Response $response): Response
    {
        $userData = $request->getAttribute('userData');

        // Get today's date
        $today = new DateTime();

        // Get the current year dynamically
        $currentYear = $today->format('Y');

        // Get the current day of the year (1-based)
        $currentDayOfYear = $today->format('z') + 1; // 'z' returns 0-365, so adding 1 makes it 1-366

        // Get the last day of the current year (December 31st)
        $endOfYear = new DateTime("last day of December $currentYear");

        // Calculate the difference between today and the end of the year
        $interval = $today->diff($endOfYear)->days;


        $args = [
            'title' => 'Home',
            'user' => $userData,
            'remainingDays' => $interval,
            'currentDayOfYear' => $currentDayOfYear,
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
