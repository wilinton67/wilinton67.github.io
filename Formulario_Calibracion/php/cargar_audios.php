<?php
require_once '../config/config.php';

header('Content-Type: text/html; charset=utf-8');

session_start();
if (!isset($_SESSION['Nombre'])) {
    header('location: index.php');
}

$usuario = $_SESSION['Usuario'];
$servicio = $_POST['servicio'];

try {
    $sql = "SELECT ch.* FROM Calibracion_Audios ch LEFT JOIN Calibracion_Notas ne ON ch.Id = ne.IdAdjunto WHERE ch.Id NOT IN (SELECT IdAdjunto FROM Calibracion_Notas WHERE Usuario_revisor = :usuario AND IdAdjunto IS NOT NULL) AND ch.Servicio = :servicio GROUP BY ch.Id;
    ";

    $query = $conexion->prepare($sql);

    $query->bindParam(':usuario', $usuario);
    $query->bindParam(':servicio', $servicio);
    if ($query->execute()) {
        if ($query->rowCount() > 0) {

            $html = '<option value="">Seleccione un Archivo...</option>';
            while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
                $html .= '<option value="' . $result['Nombre_Audio'] . '">' . $result['Nombre_Audio'] . '</option>';
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
