<?php

use app\core\Database;

class m002_auth {
    public function up()
    {
        $db = new Database();
        $sql = "CREATE TABLE `auth` (
            `id` int NOT NULL AUTO_INCREMENT,
            `username` varchar(32) NOT NULL,
            `fullname` varchar(32) NOT NULL,
            `password` varchar(256) NOT NULL,
            `email` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
            `active` int NOT NULL DEFAULT '1',
            `signup_time` timestamp NOT NULL,
            `token` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
            `updated_time` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `username` (`username`),
            UNIQUE KEY `email` (`email`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";
        $db->prepare($sql);
    }

    public function down()
    {
        $db = new Database();
        $sql = "DROP TABLE `auth`;";
        $db->prepare($sql);
    }
}