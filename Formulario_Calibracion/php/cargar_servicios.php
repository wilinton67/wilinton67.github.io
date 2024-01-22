<?php
session_start();
if (!isset($_SESSION['Nombre'])) {
    header('location: index.php');
}


if (!isset($_SESSION['Usuario'])) {

    header('location: ../index.php');
}
require_once '../config/config.php';

$cliente = $_SESSION['Cliente'];

try {
    $sql = "SELECT * FROM Calibracion_Servicios WHERE Estado = 'Activo' AND Cliente = :cliente";

    $query = $conexion->prepare($sql);
    $query->bindParam(':cliente', $cliente);
    if ($query->execute()) {
        if ($query->rowCount() > 0) {
            $html = '';
            while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
                $html .= '<option data-tabla="' . $result['Tabla'] . '" data-cliente="' . $result['Cliente'] . '" data-servicio="' . $result['Servicio'] . '">' . $result['Servicio'] . '</option>';
            }

            $respuesta = $html;
            echo $respuesta;
        } else {
            echo "No hay resultados";
        }
    }
} catch (\Throwable $e) {
    echo 'ERROR: ',  $e->getMessage();
    return;
}



$query->closeCursor();
$query = null;
$conexion = null;
