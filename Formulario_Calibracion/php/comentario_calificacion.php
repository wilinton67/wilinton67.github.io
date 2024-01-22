<?php
session_start();
if (!isset($_SESSION['Nombre'])) {
    header('location: index');
}

require_once '../config/config.php';

$id = $_GET['id'];

$sql = "SELECT Nombre_revisor, Nota, Comentario
        FROM Calibracion_Notas
        WHERE IdAdjunto = :id_audio";

$query = $conexion->prepare($sql);

$query->bindParam(':id_audio', $id);

try {
    $query->execute();
    $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
    $json = json_encode($resultado);
    echo $json;
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
