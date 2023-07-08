<?php

namespace App\Core;

use Exception;
use App\Traits\SQLGetterSetter;

class User
{
    use SQLGetterSetter;
    private $conn;
    public $username;
    public $id;
    public $table;

    /**
     * Escapes special characters in a SQL statement
     */
    protected static function check_sql_errors($value): string
    {
        $conn = Database::getConnection();
        return mysqli_real_escape_string($conn, $value);
    }

    /**
     * It fetch username by email
     */
    public static function getUsernameByEmail(string $email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $query = "SELECT `username` FROM `auth` WHERE `email` = '$email';";

            // Create a connection to database
            $conn = Database::getConnection();

            $result = $conn->query($query);

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                return $row['username'];
            } else {
                throw new Exception(__CLASS__ . "::getUsername() -> $email, email is not available.");
            }
        } else {
            throw new Exception(__CLASS__ . "::getUsername() -> Cannot filter the email.");
        }
    }

    public function __construct($user_or_email)
    {
        /**
         * User object can be constructed with either username or email
         * Check if the $user_or_email has email or not
         * Query returns userID and username
         */

        if (filter_var($user_or_email, FILTER_VALIDATE_EMAIL)) {
            // Query to fetch data using email
            $sql = "SELECT `id`, `email` FROM `auth` WHERE `email`= '$user_or_email' OR `id` = '$user_or_email' LIMIT 1";
        } else {
            // Query to fetch data using username
            $sql = "SELECT `id`, `username`  FROM `auth` WHERE `username`= '$user_or_email' OR `id` = '$user_or_email' LIMIT 1";
        }

        $this->conn = Database::getConnection();
        $this->username = $user_or_email;
        $this->id = null;
        $this->table = "auth";
        $result = $this->conn->query($sql);

        if ($result->num_rows) {
            $row = $result->fetch_assoc();
            // Updating this from database
            $this->id = $row['id'];
        // $this->username = $row['username'];
        } else {
            throw new Exception("Username is not available");
        }
    }

    /**
     * Check if the user exists
     */
    public static function exists(string $username) {
        $db = Database::getConnection();
        $sql = "SELECT * FROM `auth` WHERE `username` = '$username';";
        $result = $db->query($sql);

        if ($result && $result->num_rows == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * It fetch fullname by username
     */
    public static function getFullnameByUsername(string $username)
    {
        // Create a connection to database
        $conn = Database::getConnection();
        $query = "SELECT `fullname` FROM `auth` WHERE `username` = '$username';";
        $result = $conn->query($query);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row['fullname'];
        } else {
            throw new Exception(__CLASS__ . "::getFullnameByUsername() -> $username, fullname is not available.");
        }
    }

    /**
     * Get username of the provided user ID
     */
    public static function getUsernameById(int $uid)
    {
        $conn = Database::getConnection();

        $sql = "SELECT `username` FROM `auth` WHERE `id` = '$uid';";
        $result = $conn->query($sql);

        if ($result && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row['username'];
        } else {
            throw new Exception("Can't get the username by id: " . $uid);
        }
    }

    /**
     * Get username of the provided user ID
     */
    public static function getAvatarById(int $uid)
    {
        $conn = Database::getConnection();

        $sql = "SELECT `avatar` FROM `users` WHERE `id` = '$uid';";
        $result = $conn->query($sql);

        if ($result && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (!empty($row['avatar'])) {
                return $row['avatar'];
            } else {
                return "https://api.dicebear.com/6.x/shapes/svg?seed=" . $uid;
            }
        }
    }

    /**
     * Returns human readable number
     */
    public static function formatNumbers(int $n)
    {
        $suffixes = ['', 'K', 'M', 'B', 'T'];
        $suffixIndex = 0;
        while ($n >= 1000 && $suffixIndex < count($suffixes) - 1) {
            $n /= 1000;
            $suffixIndex++;
        }
        return round($n, 1) . $suffixes[$suffixIndex];
    }

}
