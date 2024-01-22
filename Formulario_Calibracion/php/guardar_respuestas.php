<?php
session_start();
if (!isset($_SESSION['Nombre'])) {
    header('location: index.php');
}

require_once '../config/config.php';

$nota = $_POST['nota'];
$comentario = $_POST['comentario'];
$idAudio = $_SESSION['idAudio'];
$cliente = "Confiar";
$servicio = $_POST['servicio'];
$fecha_llamada = $_POST['fecha_llamada'];
$respuestas = json_decode($_POST['respuestas']);
$usuario_revisor = $_SESSION['Usuario'];
$nombre_revisor = $_SESSION['Nombre'];
$documento_revisor = $_SESSION['Documento'];

try {
    $sql = 'INSERT INTO Calibracion_Notas (Usuario_revisor , Nota, Comentario, Cliente, Servicio, Nombre_revisor, Documento_revisor, IdAdjunto)
            VALUES (:usuario_revisor, :nota, :comentario,:Cliente, :Servicio, :nombre_revisor, :documento_revisor, :idAudio )';

    $query = $conexion->prepare($sql);

    $query->bindParam(':usuario_revisor', $usuario_revisor);
    $query->bindParam(':nota', $nota);
    $query->bindParam(':comentario', $comentario);
    $query->bindParam(':Cliente', $cliente);
    $query->bindParam(':Servicio', $servicio);
    $query->bindParam(':nombre_revisor', $nombre_revisor);
    $query->bindParam(':documento_revisor', $documento_revisor);
    $query->bindParam(':idAudio', $idAudio);

    if ($query->execute()) {

        $idEncuesta = $conexion->lastInsertId();

        foreach ($respuestas as $respuesta) {
            $pregunta = $respuesta->pregunta;
            $resp = $respuesta->respuesta;
            $peso = $respuesta->peso;
            $valor1 = $respuesta->puntaje;
            if ($resp == 'No') {
                $valor = 0;
            } else {
                $valor = $valor1;
            }
            $sql2 = 'INSERT INTO Calibracion_Respuestas (Id_Encuesta, Pregunta, Respuesta, Peso, Valor)
                    VALUES (:idEncuesta, :pregunta, :respuesta, :peso, :valor)';

            $query2 = $conexion->prepare($sql2);

            $query2->bindParam(':idEncuesta', $idEncuesta);
            $query2->bindParam(':pregunta', $pregunta);
            $query2->bindParam(':respuesta', $resp);
            $query2->bindParam(':peso', $peso);
            $query2->bindParam(':valor', $valor);

            $query2->execute();
        }

        echo 'Guardado correctamente';

        $query2->closeCursor();
        $query2 = null;
    }
} catch (\Throwable $e) {
    exit("ERROR: " . $e->getMessage());
}


$query->closeCursor();
$query = null;
$conexion = null;
