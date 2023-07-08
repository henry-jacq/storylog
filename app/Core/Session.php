<?php

namespace App\Core;

use App\Core\UserSession;
use Exception;

/**
 * PHP session wrapper
*/

class Session
{
    public static $isError = false;
    public static $user = null;
    public static $usersession = null;

    /**
     * Start a new session
     */
    public static function start()
    {
        session_start();
    }

    /**
     * Clears the session variables
     */
    public static function unset()
    {
        session_unset();
    }

    /**
     * Destroy the session
     */
    public static function destroy()
    {
        session_destroy();
    }

    /**
     * Set a new key value in session
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Delete the given session key
     */
    public static function delete($key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * Check if the session key exists or not
     */
    public static function isset($key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Get the value from given session key
     */
    public static function get($key, $default=false)
    {
        if (Session::isset($key)) {
            return $_SESSION[$key];
        } else {
            return $default;
        }
    }

    /**
     * Get the user object
     */
    public static function getUser()
    {
        return Session::$user;
    }

    /**
     * Get the the user session
     */
    public static function getUserSession()
    {
        return Session::$usersession;
    }

    // Takes an email as an input and returns if the session user has the same email
    public static function isOwnerOf($postOwner)
    {
        $sess_user = Session::$user;
        if ($sess_user) {
            if ($sess_user->getUsername() == $postOwner) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Return the running current script
     */
    public static function currentScript(): string
    {
        return basename($_SERVER['SCRIPT_NAME'], '.php');
    }

    public static function isAuthenticated()
    {
        if (is_object(Session::getUserSession())) {
            return Session::getUserSession()->isValid();
        } else {
            return false;
        }
    }

    /**
     * If not logged in, redirect the user to login page
     */
    public static function ensureLogin()
    {
        if (!Session::isAuthenticated()) {
            Session::set('_redirect', $_SERVER['REQUEST_URI']);
            header("Location: /login");
            die();
        }
    }

    /**
     * Log out the user from session
     */
    public static function logout(string $token)
    {
        try {
            UserSession::removeSession($token);
            if (session_status() === PHP_SESSION_ACTIVE) {
                self::destroy();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
