<?php

session_start();
if (!isset($_SESSION['Nombre'])) {
    header('location: index.php');
}
require_once '../config/config.php';
$encuesta = $_POST['encuesta'];
$sql = 'SELECT * FROM ' . $encuesta . ' ORDER BY Id asc';
//$sql = 'SELECT * FROM Calidad_Preguntas ORDER BY Id asc';
$query = $conexion->prepare($sql);

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

            if ($result['Tipo'] == 'Pregunta') {               # code...

                $html = "<tr class='datos-Encuesta " . $result['Tipo'] . "'>                                           
                        <td>" . $result['Pregunta'] . "</td>
                        <td class=" . $result['Tipo'] . "'><select id='logro" . $result['Id'] . "-" . $result['Atributo'] . "'>
                        <option></option>
                        <option>Si</option>
                        <option>No</option>
                        <option>N/A</option></select></td>
                        <td id='peso" . $result['Id'] . "'>" . $result['Peso'] . "</td>
                        <td id='valor" . $result['Id'] . "'>" . 0 . "</td>
                        <td id='atributo" . $result['Id'] . "' hidden>" . $result['Atributo'] . "</td>
                        <td id='errorCritico' hidden>" . $result['Error_critico'] . "</td>";
            }
            if ($result['Tipo'] == 'Titulo') {               # code...

                $html = "<tr class='datos-Encuesta " . $result['Tipo'] . "'>                                           
                <td>" . $result['Pregunta'] . "</td>
                <td><select id='logro" . $result['Id'] . "' hidden>
                <option></option>
               </select></td>
                <td class='subtotal'>" . $result['Peso'] . "</td>
                <td></td>
                <td id='atributo" . $result['Id'] . "' hidden>" . $result['Atributo'] . "</td>
                <td id='errorCritico' hidden>" . $result['Error_critico'] . "</td>";
            }
            $htmlFinal = $htmlFinal . $html;
        }

        echo ($htmlFinal);
    }
} catch (Exception $e) {
    echo 'ERROR: ',  $e->getMessage();
    return;
}
