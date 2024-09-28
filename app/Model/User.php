<?php

namespace App\Model;

class User
{
    protected $table = 'users';

    /**
     * Search users
     */
    public function searchUser(string $searchTerm)
    {
        // Search and return the user data
        return $searchTerm;
    }

    /**
     * Check by username or email
     */
    public function exists(array $data)
    {
        // Check with both username and email
        return true;
    }

    /**
     * Return current session user data
     */
    public function getUser()
    {
        return true;
        // return $this->findById($_SESSION['user']);
    }

    // Get user details
    public function getUserDetails(array $data)
    {
        return true;
        // return $this->findOne($data);
    }

    /**
     * Validate user email
     */
    public function validateEmail(string $email)
    {
        return filterEmail($email);
    }

    /**
     * Sanitize the username according to the app needs
     */
    public function validateUsername(string $username)
    {
        // Replace whitespace with underscore
        $username = str_replace(' ', '_', trim($username));

        return strtolower($username);
    }
}
