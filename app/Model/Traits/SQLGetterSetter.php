<?php

namespace Storylog\Model\Traits;

use \Exception;
use Storylog\Core\Database;

/**
 * PHP SQLGetterSetter Trait
 *
 * To use this trait, the constructer should have
 * `$id`, `$conn` and `$table` variable set.
 *
 * `$id` - The ID of the MySQL row.
 * `$conn` - MySQL connection.
 * `$table` -MySQL Table Name.
 *
 */

trait SQLGetterSetter
{
    public function __call($name, $arguments)
    {
        $property = preg_replace("/[^0-9a-zA-Z]/", "", substr($name, 3));
        $property = strtolower(preg_replace('/\B([A-Z])/', '_$1', $property));
        if (substr($name, 0, 3) == "get") {
            return $this->_get_data($property);
        } elseif (substr($name, 0, 3) == "set") {
            return $this->_set_data($property, $arguments[0]);
        } else {
            // This is for ease of debugging.
            throw new Exception(__CLASS__ . "::__call() -> $name, function is unavailable.");
        }
    }

    // Used to retrieve data from the database
    private function _get_data($var)
    {
        // Create a connection, if it doesn't exist
        if (!$this->conn) {
            $this->conn = Database::getConnection();
        }
        try {
            // Query to get data from users table
            $sql = "SELECT `$var` FROM `$this->table` WHERE `id` = '$this->id'";
            $result = $this->conn->query($sql);
            if ($result and $result->num_rows == 1) {
                return $result->fetch_assoc()["$var"];
            } else {
                return null;
            }
        } catch (Exception $e) {
            throw new Exception(__CLASS__ . "::_get_data() -> $var, data unavailable.");
        }
    }

    // Used to set the data in the database
    private function _set_data($var, $data)
    {
        // Create a connection, if it doesn't exist
        if (!$this->conn) {
            $this->conn = Database::getConnection();
        }
        try {
            // Query to update the data in users table
            $sql = "UPDATE `$this->table` SET `$var`='$data' WHERE `id`='$this->id';";
            if ($this->conn->query($sql)) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw new Exception(__CLASS__ . "::_set_data -> $var, data unavailable.");
        }
    }

    public function getID()
    {
        return $this->id;
    }
}
