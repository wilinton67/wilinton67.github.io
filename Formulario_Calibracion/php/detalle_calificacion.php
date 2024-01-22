<?php
session_start();
if (!isset($_SESSION['Nombre'])) {
    header('location: index.php');
}

require_once '../config/config.php';

$id = $_GET['id'];

$sql = "SELECT A.Pregunta, 
                MAX(CASE WHEN B.Usuario_revisor = 'katerine.sepulveda' THEN A.Respuesta ELSE NULL END) AS 'Katerine Sepulveda', 
                MAX(CASE WHEN B.Usuario_revisor = 'liliana.agudelo' THEN A.Respuesta ELSE NULL END) AS 'Liliana Agudelo', 
                MAX(CASE WHEN B.Usuario_revisor = 'paulina.escobar' THEN A.Respuesta ELSE NULL END) AS 'Paulina Escobar', 
                MAX(CASE WHEN B.Usuario_revisor = 'kelly.cartagena' THEN A.Respuesta ELSE NULL END) AS 'Kelly Cartagena', 
                MAX(CASE WHEN B.Usuario_revisor = 'leidyorlas.6' THEN A.Respuesta ELSE NULL END) AS 'Leidy Orlas',
                MAX(CASE WHEN B.Usuario_revisor = 'danielaristizabal.2' THEN A.Respuesta ELSE NULL END) AS 'Jacobo Aristizabal',
                MAX(CASE WHEN B.Usuario_revisor = 'karollondono.4' THEN A.Respuesta ELSE NULL END) AS 'Karol Londono',
                MAX(CASE WHEN B.Usuario_revisor = 'coordinador07' THEN A.Respuesta ELSE NULL END) AS 'Sandra Gutierrez',
                MAX(CASE WHEN B.Usuario_revisor = 'lady.ortega' THEN A.Respuesta ELSE NULL END) AS 'Lady Johana Ortega',
                MAX(CASE WHEN B.Usuario_revisor = 'liliana.mesa' THEN A.Respuesta ELSE NULL END) AS 'Liliana Mesa',
                MAX(CASE WHEN B.Usuario_revisor = 'agente132' THEN A.Respuesta ELSE NULL END) AS 'German Martinez'
        FROM Calibracion_Respuestas as A 
        JOIN Calibracion_Notas B ON A.Id_Encuesta = B.Id 
        WHERE B.IdAdjunto = :id_audio GROUP BY A.Pregunta";

$query = $conexion->prepare($sql);

$query->bindParam(':id_audio', $id);

try {
    $query->execute();
    $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
    $json = json_encode($resultado);
    echo $json;
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
