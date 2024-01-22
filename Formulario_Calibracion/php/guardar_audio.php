<?php
session_start();
if (!isset($_SESSION['Nombre'])) {
    header('location: index.php');
}
include_once '../config/config.php';
include_once './validar_ext.php';

$asesor     = $_POST['asesor'];
$usuario    = $_POST['usuarioAsesor'];
$fecha      = $_POST['fechaLlamada'];
$nombreCliente = $_POST['nombreCliente'];
$cedulaCliente = $_POST['cedulaCliente'];
$servicio = $_POST['servicio'];
$id_llamada = $_POST['idLlamada'];
$subidoPor = $_SESSION['Nombre'];

$audio = $_FILES['archivoHTML'];

check_doc_mime($audio['tmp_name']);

try {

    if (check_doc_mime($audio['tmp_name'])) {
        $ruta = $audio['tmp_name'];
        $archivo = $audio['name'];

        // Verificar si el archivo de audio ya existe en la base de datos
        //$sql_check = "SELECT COUNT(*) FROM Calibracion_Audios WHERE Nombre_Audio = :audio";
        $sql_check = "SELECT COUNT(*) FROM Calibracion_Audios WHERE Nombre_Audio = :audio ";

        $query_check = $conexion->prepare($sql_check);
        $query_check->bindParam(':audio', $archivo);
        $query_check->execute();

        $archivo_existente = $query_check->fetchColumn();

        if ($archivo_existente) {
            echo "El archivo de audio ya existe.";
        } else {
            // Insertar el archivo de audio si no existe
            $sql = "INSERT INTO Calibracion_Audios (Nombre_asesor, Usuario_asesor, Nombre_Audio, Nombre_cliente , Cedula_cliente, Servicio, Fecha_Llamada, Id_llamada, guardado_por)
                    VALUES (:asesor, :usuario, :audio, :nombreCliente, :cedulaCliente, :servicio, :fecha, :id_call , :subidoPor)";

            $query = $conexion->prepare($sql);

            $query->bindParam(':asesor', $asesor);
            $query->bindParam(':usuario', $usuario);
            $query->bindParam(':audio', $archivo);
            $query->bindParam(':nombreCliente', $nombreCliente);
            $query->bindParam(':cedulaCliente', $cedulaCliente);
            $query->bindParam(':servicio', $servicio);
            $query->bindParam(':fecha', $fecha);
            $query->bindParam(':id_call', $id_llamada);
            $query->bindParam(':subidoPor', $subidoPor);


            if (!file_exists('../adjuntos/' . $servicio)) {
                mkdir('../adjuntos/' . $servicio);
            }

            move_uploaded_file($ruta, '../adjuntos/' . $servicio . '/' . $archivo);
            if ($query->execute()) {

                echo "Archivo subido correctamente";
            }
        }
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}

$query->closeCursor();
$conexion = null;
