<?php

define("BD_HOST", "10.180.139.201");
// define("BD_HOST", "179.50.77.58");
define("BD_USER", "soportforce_admin");
define("BD_PASS", "P@sswords0p0rt3C0nc3ptBP@");
define("BD_NAME", "soportforce_Interna");

try {
    $conexion2 = new PDO("mysql:host=" . BD_HOST . ";dbname=" . BD_NAME, BD_USER, BD_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'"));
} catch (PDOException $e) {
    exit("ERROR: " . $e->getMessage());
}
