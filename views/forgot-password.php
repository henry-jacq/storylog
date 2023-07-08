<?php

use App\Core\Auth;
use App\Core\View;
use App\Core\Session;

$get_token = isset($_GET['reset_password_token']) ? $_GET['reset_password_token'] : '';

if (!empty($get_token)) {
    $reset_email = Session::get('reset_email'); // False if already expired
    $reset_creds = Auth::retrieveResetCredentials($reset_email);
    if ($reset_creds != null) {
        $db_token = $reset_creds['token'];
        $timestamp = $reset_creds['updated_time'];

        if (Auth::verifyTokenExpiration($timestamp) && $get_token == $db_token) {
            View::renderTemplate('templates/auth/change-password');
        } else {
            if (isset($reset_email)) {
                Session::delete('reset_email');
                Auth::revokeResetCredentials($reset_email);
            }
            View::loadErrorPage();
        }
    } else {
        View::loadErrorPage();
    }
} else {
    View::renderTemplate('templates/auth/reset-password');
}
