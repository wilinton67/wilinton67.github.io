<?php
session_start();
if (!isset($_SESSION['Nombre'])) {
    header('location: index');
}

require_once '../config/config.php';


$sql = "SELECT Id, Nombre_asesor, Nombre_Audio, Fecha_llamada
        FROM Calibracion_Audios";

$query = $conexion->prepare($sql);


try {
    $query->execute();
    $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
    $json = json_encode($resultado);
    echo $json;
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
