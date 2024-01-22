<?php

include_once("../config/config2.php");
session_start();
if (!isset($_SESSION['Nombre'])) {
    header('location: index.php');
}
$usuario = $_POST['usuario_web'];

try {
    $sql = 'SELECT nombre FROM Socio_datos WHERE usuarioRed = :usuarioRed';

    $query = $conexion2->prepare($sql);

    $query->bindParam(':usuarioRed', $usuario);

    if ($query->execute()) {
        if ($query->rowCount() > 0) {
            $result = $query->fetch(PDO::FETCH_ASSOC);

            $nombre = $result['nombre'];
            if ($nombre == '') {
                echo 'No se puedo encontrar el usuario';
            } else {

                echo $nombre;
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
