<?php
require_once '../config/config.php';
session_start();
if (!isset($_SESSION['Nombre'])) {
    header('location: index.php');
}
$audio = $_POST['audio']; // Cambia 'archivoHTML' por 'audio' para que coincida con el nombre en el objeto postData

try {
    $sql = "SELECT * FROM Calibracion_Audios WHERE Nombre_Audio = :audio";

    $query = $conexion->prepare($sql);

    $query->bindParam(':audio', $audio);

    if ($query->execute()) {
        if ($query->rowCount() > 0) {
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $_SESSION['idAudio'] = $result['Id'];
            $json = json_encode($result);

            echo $json;
        } else {
            echo json_encode(["error" => "No hay resultados"]); // Devuelve un objeto JSON en caso de que no haya resultados
        }
    }
} catch (Exception $e) {
    echo json_encode(["error" => 'ERROR: ' . $e->getMessage()]); // Devuelve un objeto JSON en caso de error
    return;
}

$query->closeCursor();
$query = null;
$conexion = null;
