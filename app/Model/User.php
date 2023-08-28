<?php

namespace Storylog\Model;

use Exception;
use Storylog\Core\Session;
use Storylog\Core\Database;
use Storylog\Core\Traits\SqlGetterSetter;

class User
{
    public $id;
    private $conn;
    private $table = 'auth';
    protected $length = 32;

    use SqlGetterSetter;
    
    public function __construct(
        private readonly Database $db,
        private readonly Session $session,
    )
    {
        $this->db->setTable($this->table);

        if (!$this->conn) {
            $this->conn = $this->db->getDB();
        }
    }

    public function create(array $data)
    {
        try {
            if ($result = $this->db->insert($data)) {
                return $result;
            }
            
            return false;

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Return user data if it exists in the DB
     */
    public function exists(string|array $data): array|bool
    {
        $conditions = [];

        if (is_array($data)) {
            foreach ($data as $value) {
                $conditions[] = "`username` = '{$value}' OR `email` = '{$value}'";
            }
        } else {
            $conditions[] = "`username` = '{$data}' OR `email` = '{$data}'";
        }

        $query = "SELECT * FROM $this->table WHERE " . implode(" OR ", $conditions);
        
        $result = $this->db->rows($query);

        if (count($result) > 1) {
            throw new Exception('Duplicate User Entry Found!');
        }

        return empty($result) ? false : $result;
    }

    public function getUser()
    {
        if (!isset($this->id)) {
            $this->id = $this->session->get('user');
        }
        return $this->db->getRowById($this->id);
    }
    
    public function getById(int $id)
    {
        return $this->db->getRowById($id);
    }

    public function getByEmail(string $email)
    {
        $query = "SELECT * FROM $this->table WHERE `email` = ?'";

        if ($this->validateEmail($email)) {
            return $this->db->run($query, [$email]);
        }

        return false;
        
    }

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