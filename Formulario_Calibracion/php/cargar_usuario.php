<?php
session_start();
if (!isset($_SESSION['Nombre'])) {
    header('location: index.php');
}
require_once "../config/config2.php";

$nombre = $_POST['nombre'];

try {
    $sql = 'SELECT usuarioRed FROM Socio_datos WHERE nombre = :nombre';

    $query = $conexion2->prepare($sql);

    $query->bindParam(':nombre', $nombre);

    if ($query->execute()) {
        if ($query->rowCount() > 0) {
            $result = $query->fetch(PDO::FETCH_ASSOC);

            $usuario = $result['usuarioRed'];
            if ($usuario == '') {
                echo 'No se puedo encontrar el usuario';
            } else {
                echo $usuario;
            }
        }
    }
} catch (\Throwable $e) {
    echo 'ERROR: ',  $e->getMessage();
    return;
}

$query->closeCursor();
$query = null;
$conexion = null;
