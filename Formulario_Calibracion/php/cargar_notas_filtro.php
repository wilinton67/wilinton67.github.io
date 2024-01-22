<?php
session_start();
if (!isset($_SESSION['Nombre'])) {
    header('location: index.php');
}
require_once '../config/config.php';

$usuario = $_SESSION['usuario'];
$estado = $_POST['estado'];
$servicio = $_POST['servicio'];
$fecha = $_POST['fecha_monitoreo'];

$sql = 'SELECT * FROM Calibracion_Notas WHERE Usuario_asesor = :usuario AND Estado = :estado ';

if ($fecha != "") {
    $fechaInicio = $fecha . ' 00:00:00';
    $fechaFin = $fecha . ' 23:59:59';
    $filtroFecha = "AND Fecha_monitoreo BETWEEN :fechaIni AND :fechaFin ";
} else {
    $filtroFecha = "";
}

if ($servicio != "Auditoria") {
    $filtroServicio = " AND Servicio = :servicio ";
} else {
    $filtroServicio = "";
}

$sql .= $filtroFecha . $filtroServicio;


$query = $conexion->prepare($sql);

$query->bindParam(':usuario', $usuario);
$query->bindParam(':estado', $estado);



if ($servicio != "Auditoria") {
    $query->bindParam(':servicio', $servicio);
}

if ($fecha != "") {
    $query->bindParam(':fechaIni', $fechaInicio);
    $query->bindParam(':fechaFin', $fechaFin);
}
try {
    if ($query->execute()) {

        if ($query->rowCount() == 0) {
            $html = "<tr class='datos-Cita'>
                    <td colspan='5'>Sin resultados</td>
                </tr>";
            echo ($html);
            return;
        }

        $html = "";
        $htmlFinal = "";

        while ($result = $query->fetch(PDO::FETCH_ASSOC)) {

            $html = "<tr class='datos-auditorias'>                                    
                        <td data-id='" . $result['Id'] . "'>" . $result['Id'] . "</td>
                        <td>" . $result['Nombre_asesor'] . "</td>
                        <td>" . $result['Fecha_monitoreo'] . "</td>
                        <td>" . $result['Fecha_llamada'] . "</td>
                        <td>" . $result['Nota'] . "</td>
                        <td>" . $result['Comentario'] . "</td>
                        <td>" . $result['Comentario_rechazo'] . "</td>
                        <td>" . $result['Servicio'] . "</td>
                       <td class='campo-estado'>" . $result['Estado'] . "</td>";

            $htmlFinal = $htmlFinal . $html;
        }

        echo ($htmlFinal);
    }
} catch (Exception $e) {
    echo 'ERROR: ',  $e->getMessage();
    return;
}
