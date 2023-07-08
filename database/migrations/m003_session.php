<?php

use app\core\Database;

class m003_session {
    public function up()
    {
        $db = new Database();
        $sql = "CREATE TABLE `session` (
            `id` int NOT NULL AUTO_INCREMENT,
            `uid` int NOT NULL,
            `token` varchar(32) NOT NULL,
            `login_time` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
            `ip` varchar(20) NOT NULL,
            `user_agent` varchar(256) NOT NULL,
            `active` int NOT NULL DEFAULT '1',
            `fingerprint` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `uid` (`uid`),
            CONSTRAINT `session_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `auth` (`id`) ON DELETE RESTRICT
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";
        $db->prepare($sql);
    }

    public function down()
    {
        $db = new Database;
        $sql = "DROP TABLE `session`";
        $db->prepare($sql);
    }
}