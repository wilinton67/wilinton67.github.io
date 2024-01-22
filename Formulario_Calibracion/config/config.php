<?php

define("BD_HOST", "localhost");
define("BD_USER", "root");
define("BD_PASS", "");
define("BD_NAME", "conceptb_calidad");

// define("BD_HOST", "www.conceptbpo.com.co");
// define("BD_USER", "conceptb_dbmanag");
// define("BD_PASS", "Febrero2021*");
// define("BD_NAME", "conceptb_calibracion");

try {
    $conexion = new PDO("mysql:host=" . BD_HOST . ";dbname=" . BD_NAME, BD_USER, BD_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'"));
} catch (PDOException $e) {
    exit("ERROR: " . $e->getMessage());
}
