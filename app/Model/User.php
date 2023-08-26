<?php

namespace Storylog\Model;

use Exception;
use Storylog\Core\Session;
use Storylog\Core\Database;
use Storylog\Core\Traits\SqlGetterSetter;

class User
{
    private $id;
    private $conn;
    private $table = 'auth';

    use SqlGetterSetter;
    
    public function __construct(
        private readonly Database $db,
        private readonly Session $session,
    )
    {
        $this->db->setTable($this->table);
        $this->id = $this->session->get('user');

        if (!$this->conn) {
            $this->conn = $this->db->getDB();
        }
    }

    public function create(array $data)
    {
        try {
            $query = "SELECT * FROM auth WHERE username = ?";
            if ($this->db->getCount($query, [$data['username']]) != 1) {
                return $this->db->insert($data);
            }
            return false;

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getUser()
    {
        return $this->db->getRowById($this->id);
    }
    
    public function getById(int $id)
    {
        return $this->db->getRowById($id);
    }
}