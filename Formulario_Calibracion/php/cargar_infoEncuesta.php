<?php

session_start();
if (!isset($_SESSION['Nombre'])) {
    header('location: index.php');
}
require_once '../config/config.php';
$id = $_POST['id'];
$sql = 'SELECT * FROM Calibracion_Respuestas WHERE Id_Encuesta = :id';
//$sql = 'SELECT * FROM Calidad_Preguntas ORDER BY Id asc';
$query = $conexion->prepare($sql);

$query->bindParam(':id', $id);

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

            # code...
            if ($result['Respuesta'] == '' && $result['Peso'] != 'Total') {
                $html = "<tr>
            <td class='Titulo'>" . $result['Pregunta'] . "</td>                                           
                <td>" . $result['Respuesta'] . "</td>
               <td class='subtotal'>" . $result['Peso'] . "</td>
               <td></td>
               </tr>";
            } elseif ($result['Respuesta'] == '' && $result['Peso'] == 'Total') {
                $html = "<tr>
            <td>" . $result['Pregunta'] . "</td>                                           
                <td>" . $result['Respuesta'] . "</td>
               <td class='Total_string'>" . $result['Peso'] . "</td>
               <td class='Total_number'>" . $result['Valor'] . "</td>
               </tr>";
            } elseif ($result['Respuesta'] == 'No') {
                $html = "<tr class='NO'>
            <td>" . $result['Pregunta'] . "</td>                                           
                <td>" . $result['Respuesta'] . "</td>
               <td>" . $result['Peso'] . "</td>
               <td>" . $result['Valor'] . "</td>
               </tr>";
            } else {
                $html = "<tr>
                <td>" . $result['Pregunta'] . "</td>                                           
                <td>" . $result['Respuesta'] . "</td>
               <td>" . $result['Peso'] . "</td>
               <td>" . $result['Valor'] . "</td>
               </tr>";
            }


            $htmlFinal = $htmlFinal . $html;
        }
        echo ($htmlFinal);
    }
} catch (Exception $e) {
    echo 'ERROR: ',  $e->getMessage();
    return;
}
