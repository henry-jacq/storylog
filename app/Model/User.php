<?php

namespace Storylog\Model;

use Storylog\Core\Database;
use Storylog\Model\Traits\SQLGetterSetter;

class User
{
    use SQLGetterSetter;
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;    
    }

    public function getUser()
    {
        // Return object
        return '';
    }
}