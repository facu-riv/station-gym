<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'db_station_gym');
define('DB_USER', 'root');
define('DB_PASS', '');

function getConnection() {
    try {
        $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASS);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}

session_start();
?>