<?php
include_once '../config/config.php';
session_start();
if (!isset($_SESSION['Nombre'])) {
    header('location: index.php');
}
$usuario = $_SESSION['Usuario'];
$pass = $_POST['password'];

try {

    $pass = password_hash($pass, PASSWORD_DEFAULT);

    $sql = "UPDATE Calibracion_Usuarios SET Password = :pass, Cambio_password = 'No' WHERE `Usuario` = :usuario";
    $query = $conexion->prepare($sql);

    $query->bindParam(':usuario', $usuario);
    $query->bindParam(':pass', $pass);

    if (!$query->execute()) {
        echo "Error";
        return;
    }

    echo "success";
} catch (\Throwable $e) {
    echo ("ERROR: " . $e->getMessage());
}

$query->closeCursor();
$query = null;
$conexion = null;
