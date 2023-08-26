<?php

namespace Storylog\Core;

use Exception;
use Storylog\Model\User;
use Storylog\Core\Session;
use Storylog\Core\Database;
use Storylog\Interfaces\AuthInterface;

class Auth implements AuthInterface
{
    private $table = 'auth';
    
    public function __construct(
        private readonly User $user,
        private readonly Database $db,
        private readonly Session $session,
    )
    {
        $this->db->setTable($this->table);
    }
    
    /**
     * Register user
     */
    public function register($username, $fullname, $email, $password)
    {
        // Amount of cost requires to generate a random hash
        $options = [
            'cost' => 8
        ];
        $fullname = trim($fullname);
        $username = strtolower($username);
        $password = password_hash($password, PASSWORD_DEFAULT, $options);

        $data = [
            'username' => $username,
            'fullname' => $fullname,
            'password' => $password,
            'email' => $email,
            'active' => 0,
            'created_at' => now()
        ];

        try {
            return $this->db->insert($data);
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Login user
     */
    public function login(array $credentials)
    {        
        $query = "SELECT * FROM $this->table WHERE `username` = '{$credentials['user']}' OR `email` = '{$credentials['user']}'";

        $user = $this->db->rows($query);

        if (count($user) > 1) {
            throw new Exception('Duplicate User Entry Found!');
        }
       
        if (empty($user)) {
            return false;
        }
        
        $user = $user[0];

        if ($this->checkCredentials($user, $credentials)) {
            $this->session->put('user', $user['id']);
            return $this->user->getId();
        }

        return false;
    }

    public function checkCredentials(array $user, array $credentials): bool
    {
        return password_verify($credentials['password'], $user['password']);
    }

    public function logout(): void
    {
        unset($_SESSION['user']);

        $this->user = null;
    }
    
}