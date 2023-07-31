<?php

namespace Storylog\Model;

use Storylog\Core\Database;

class Blog
{
    public function __construct(private readonly Database $conn)
    {
        $this->conn->setTable('auth');
    }

    public function create(array $data)
    {
        $this->conn->insert($data);
    }
}