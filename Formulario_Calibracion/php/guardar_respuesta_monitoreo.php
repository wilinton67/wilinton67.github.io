<?php
session_start();

if (!isset($_SESSION['Usuario'])) {

    header('location: ../index.php');
}
require_once '../config/config.php';

$id = $_POST['id'];
$respuestaMonitoreo = $_POST['respuestaMonitoreo'];
$comentarioRechazo = $_POST['comentarioRechazo'];


try {
    $sql = "UPDATE `Calibracion_Notas` SET `Estado`=:respuestaMonitoreo,`Comentario_rechazo`=:comentarioRechazo WHERE id = :id";

    $query = $conexion->prepare($sql);

    $query->bindParam(':respuestaMonitoreo', $respuestaMonitoreo);
    $query->bindParam(':comentarioRechazo', $comentarioRechazo);
    $query->bindParam(':id', $id);

    if ($query->execute()) {
    }
} catch (\Throwable $e) {
    exit("ERROR: " . $e->getMessage());
}


$query->closeCursor();
$query = null;
$conexion = null;
