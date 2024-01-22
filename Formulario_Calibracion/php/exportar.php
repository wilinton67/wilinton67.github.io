<?php
session_start();
if (!isset($_SESSION['Nombre'])) {
    header('location: index.php');
}
include_once('../config/config.php');
include_once('../config/config2.php');
require '../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$nombre = '%' . $_SESSION['nombre'] . '%';
try {
    $sql = "SELECT usuarioRed from Socio_datos sd where jefeDirecto like :nombre";

    $query = $conexion2->prepare($sql);

    $query->bindParam(':nombre', $nombre);

    if ($query->execute()) {
        if ($query->rowCount() > 0) {
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $usuarios = implode(', ', $result);
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getActiveSheet()->getStyle('A1:P1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('00984a');

        $spreadsheet->getActiveSheet()->getStyle('A1:P1')
            ->getFont()->getColor()->setARGB('FFFFFFFF');

        $spreadsheet->getActiveSheet()->getStyle('A1:P1')->getFont()->setBold(true);

        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'Usuario_revisor');
        $sheet->setCellValue('C1', 'Nota');
        $sheet->setCellValue('D1', 'Comentario');
        $sheet->setCellValue('E1', 'Nombre_revisor');
        $sheet->setCellValue('F1', 'Documento_revisor');
        $sheet->setCellValue('G1', 'Fecha_monitoreo');
        $sheet->setCellValue('H1', 'Servicio');
        $sheet->setCellValue('I1', 'Fecha_llamada');
        $sheet->setCellValue('J1', 'Nombre_asesor');
        $sheet->setCellValue('K1', 'Usuario_asesor');
        $sheet->setCellValue('L1', 'Cliente');
        $sheet->setCellValue('M1', 'Id_llamada');
        $sheet->setCellValue('N1', 'Cartera');
        $sheet->setCellValue('O1', 'Estado');
        $sheet->setCellValue('P1', 'Comentario_rechazo');

        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_fin    = $_POST['fecha_fin'];

        $fecha_inicio_str = strtotime($fecha_inicio);
        $fecha_fin_str = strtotime($fecha_fin);


        if ($fecha_inicio_str > $fecha_fin_str) {
            echo '<script type="text/javascript">
    alert("La fecha de Inicio debe ser anterior a la fecha final");
    window.location.href="../index.php";
    </script>';
            exit();
        }

        $sql2 = "SELECT * FROM Calibracion_Notas WHERE Fecha_monitoreo between :fecha_inicio and :fecha_fin AND Usuario_asesor IN (:usuarios) AND Usuario_revisor IS NOT NULL;";



        $query2 = $conexion->prepare($sql2);
        $fecha_inicio = $fecha_inicio . ' 00:00:00';
        $fecha_fin = $fecha_fin . ' 23:59:59';


        $query2->bindParam(':fecha_inicio', $fecha_inicio);
        $query2->bindParam(':fecha_fin', $fecha_fin);
        $query2->bindParam(':usuarios', $usuarios);
        if ($query2->execute()) {

            $resultado = $query2->fetchAll(PDO::FETCH_ASSOC);
            $contador = 2;

            foreach ($resultado as $valor) {
                $sheet->setCellValue('A' . $contador, $valor['Id']);
                $sheet->setCellValue('B' . $contador, $valor['Usuario_revisor']);
                $sheet->setCellValue('C' . $contador, $valor['Nota']);
                $sheet->setCellValue('D' . $contador, $valor['Comentario']);
                $sheet->setCellValue('E' . $contador, $valor['Nombre_revisor']);
                $sheet->setCellValue('F' . $contador, $valor['Documento_revisor']);
                $sheet->setCellValue('G' . $contador, $valor['Fecha_monitoreo']);
                $sheet->setCellValue('H' . $contador, $valor['Servicio']);
                $sheet->setCellValue('I' . $contador, $valor['Fecha_llamada']);
                $sheet->setCellValue('J' . $contador, $valor['Nombre_asesor']);
                $sheet->setCellValue('K' . $contador, $valor['Usuario_asesor']);
                $sheet->setCellValue('L' . $contador, $valor['Cliente']);
                $sheet->setCellValue('M' . $contador, $valor['Id_llamada']);
                $sheet->setCellValue('N' . $contador, $valor['Cartera']);
                $sheet->setCellValue('O' . $contador, $valor['Estado']);
                $sheet->setCellValue('P' . $contador, $valor['Comentario_rechazo']);

                $contador = $contador + 1;
            }
        }


        $query2->closeCursor();
        $query2 = null;
        $conexion = null;
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Monitoreo.xlsx"');
        $writer->save('php://output');
    }
} catch (\Throwable $e) {
    echo 'ERROR: ',  $e->getMessage();
    return;
}


$query->closeCursor();
$query = null;
$conexion2 = null;
