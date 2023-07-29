<?php

namespace Storylog\Core;

class Auth
{
    /**
     * Register user
     */
    public static function register($username, $fullname, $email, $password)
    {
        // Amount of cost requires to generate a random hash
        $options = [
            'cost' => 8
        ];
        $password = password_hash($password, PASSWORD_DEFAULT, $options);
        $conn = Database::getConnection();
        $username = strtolower(Database::check_sql_errors($username));
        $fullname = Database::check_sql_errors(trim($fullname));
        $password = Database::check_sql_errors($password);
        $email = Database::check_sql_errors($email);

        // TODO: In future, change the sql query table to class variable which is declared in database_class_php file
        $sql = "INSERT INTO `auth` (`username`, `fullname`, `password`, `email`, `active`, `signup_time`) VALUES ('$username', '$fullname', '$password', '$email', '0', now());";

        // try {
        //     return $conn->query($sql);
        // } catch (Exception $e) {
        //     return false;
        // }
    }

    /**
     * Login user
     */
    public static function login($user, $password)
    {
        if (filter_var($user, FILTER_VALIDATE_EMAIL)) {
            $query = "SELECT * FROM `auth` WHERE `email` = '$user'";
        } else {
            $query = "SELECT * FROM `auth` WHERE `username` = '$user'";
        }

        $conn = Database::getConnection();
        $user = strtolower(Database::check_sql_errors($user));

        // $result = $conn->query($query);
        // if ($result->num_rows == 1) {
        //     $row = $result->fetch_assoc();
        //     if (password_verify($password, $row['password'])) {
        //         return $row['username'];
        //     } else {
        //         return false;
        //     }
        // } else {
        //     return false;
        // }
    }

}