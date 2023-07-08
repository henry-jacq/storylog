<?php

use app\core\Database;

class m001_initial {
    public function up()
    {
        $db = new Database();
        $db->prepare("SET NAMES utf8;");
        $db->prepare("SET time_zone = '+00:00'");
        $db->prepare("SET foreign_key_checks = 0");
        $db->prepare("SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");
        $db->prepare("SET NAMES utf8mb4;");
    }

    public function down()
    {
        $db = new Database();
        $sql = "DROP NAMES, time_zone, foreign_key_checks, sql_mode;";
        $db->prepare($sql);
    }
}