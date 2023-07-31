<?php

namespace Storylog\Model;

use Exception;
use Storylog\Core\Database;

class User
{
    public function __construct(private readonly Database $conn)
    {
        $this->conn->setTable('auth');
    }

    public function create(array $data)
    {
        try {
            $query = "SELECT * FROM auth WHERE username = ?";
            if ($this->conn->getCount($query, [$data['username']]) != 1) {
                return $this->conn->insert($data);
            }
            return false;

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}