<?php

namespace Storylog\Core\Traits;

use \Exception;

trait SqlGetterSetter
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
        try {
            // Query to get data from users table
            $sql = "SELECT `$var` FROM `$this->table` WHERE `id` = ?";
            $result = $this->db->run($sql, [$this->id]);
            if ($result && $result->num_rows == 1) {
                return $result->fetch()["$var"];
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
        try {
            // Query to update the data in users table
            $sql = "UPDATE `$this->table` SET `$var`='$data' WHERE `id` = $this->id";
            $result = $this->db->run($sql);
            
            if ($result) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw new Exception(__CLASS__ . "::_set_data -> $var, data unavailable.");
        }
    }

    public function update(int $blogId, array $data)
    {
        $newData = [
            'title' => $data['title'],
            'slug' => $data['slug'],
            'featured_image' => $data['featured-image'],
            'category' => $data['category'],
            'excerpt' => $data['excerpt'],
            'content' => $data['content'],
            'updated_at' => now(),
        ];

        // here check for empty key and then remove those keys

        try {
            $this->db->update($newData, ['id' => $blogId]);
            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getID()
    {
        return $this->id;
    }

    /**
     * Get ID of the provided username
     */
    public function getIdByUsername(string $username)
    {
        $conn = $this->db->getDB();
        $username = mysqli_real_escape_string($conn, $username);

        $sql = "SELECT `id` FROM `auth` WHERE `username` = '$username';";
        $result = $conn->query($sql);

        if ($result && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row['id'];
        } else {
            throw new Exception("Can't get the user ID using username: " . $username);
        }
    }
}