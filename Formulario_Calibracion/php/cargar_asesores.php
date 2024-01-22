<?php
session_start();
if (!isset($_SESSION['Nombre'])) {
    header('location: index.php');
}

require_once '../config/config2.php';
$cliente = $_POST['cliente'];

try {

    if ($cliente == 'Colectora') {
        $sql = "SELECT Nombre FROM Socio_datos WHERE servicio LIKE '%Cobranzas%' AND estado = 'Activo'";
    } else {
        $sql = "SELECT Nombre FROM Socio_datos WHERE linea LIKE '%" . $cliente . "%' AND estado = 'Activo'";
    }

    $query = $conexion2->prepare($sql);



    if ($query->execute()) {
        if ($query->rowCount() > 0) {
            $html = '<option value=""></option>';
            while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
                $html .= '<option value="' . $result['Nombre'] . '">' . $result['Nombre'] . '</option>';
            }
            echo $html;
        } else {
            echo "<option value=''>No hay resultados</option>";
        }
    }
} catch (Exception $e) {
    echo 'ERROR: ',  $e->getMessage();
}


$query->closeCursor();
$query = null;
$conexion = null;
