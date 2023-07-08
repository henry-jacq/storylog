<?php

namespace App\Core;

use Exception;

/**
 * This class is used to access the database.
 * We have a static variable set to null.
 * Once we established a database connection, it will be stored in $conn variable.
 * And everytime getConnection() method called it wont't make a new connection rather it will return the connection stored from $conn variable.
 * For the first time it will create a new connection to database and this connection is repeated everytime this method is accessed.
 * NOTE: It will not open connections for multiple times, rather it uses the same connection, it's a secure practice to establish connection to database.
 */

class Database
{
    public static $conn = null;
    public $con;
    
    public function __construct()
    {
        $server = DB_HOST ?? '';
        $db_user = DB_USER ?? '';
        $db_pass = DB_PASS ?? '';
        $dbname = DB_NAME ?? '';

        if ($this->con == null) {
            // Create new connection
            $connection = new \mysqli($server, $db_user, $db_pass, $dbname);

            // Check connection
            if ($connection->connect_error) {
                throw new \ErrorException($connection->connect_error);
            } else {
                $this->con = $connection;
                return $this->con;
            }
        } else {
            // Return the existing connection
            return $this->con;
        }
    }

    // Establish a new connection or return the existing connection.
    public static function getConnection()
    {
        if (Database::$conn == null) {
            // Get credentials from config
            $server = DB_HOST;
            $db_user = DB_USER;
            $db_pass = DB_PASS;
            $dbname = DB_NAME;

            // To establish connection to the mysql database
            $connection = new \mysqli($server, $db_user, $db_pass, $dbname);

            // Check connection
            if ($connection->connect_error) {
                // TODO: Replace this with exception handling in FUTURE.
                die("Connection failed: " . $connection->connect_error);
            } else {
                // printf("New connection establishing...\n");
                Database::$conn = $connection;
                return Database::$conn;
            }
        } else {
            // printf("Returning the existing connection...\n");
            return Database::$conn;
        }
    }

    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $newMigrations = [];
        $files = scandir(APP_ROOT . '/database/migrations');
        $toApplyMigrations = array_diff($files, $appliedMigrations);
        foreach ($toApplyMigrations as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }

            require_once APP_ROOT . '/database/migrations/' . $migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();
            $this->log("Applying $migration migration...");
            $instance->up();
            $this->log("Migration $migration applied!");
            $newMigrations[] = $migration;
        }

        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            $this->log("All migrations are applied!");
        }
    }

    protected function createMigrationsTable()
    {
        $this->con->query("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )  ENGINE=INNODB;");
    }

    protected function getAppliedMigrations()
    {
        $results = [];
        $statement = $this->con->query("SELECT migration FROM migrations");

        while ($row = $statement->fetch_column()) {
            $results[] = $row;
        }
        return $results;
    }

    protected function saveMigrations(array $newMigrations)
    {
        $str = implode(',', array_map(fn($m) => "('$m')", $newMigrations));
        try {
            $this->con->query("INSERT INTO migrations (migration) VALUES $str");
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function prepare($sql)
    {
        return $this->con->query($sql);
    }

    private function log($message)
    {
        echo "-> [" . date("Y-m-d H:i:s") . "] - " . $message . PHP_EOL;
    }
}
