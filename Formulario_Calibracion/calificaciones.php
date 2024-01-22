<?php
session_start();

if (!$_SESSION['Nombre']) {
    header('location: index');
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calificaciones campañas salida </title>
    <!-- BOOTSTRAP 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" href="./css/inicio.css">
    <link rel="stylesheet" href="./css/calificaciones.css">
    <link rel="icon" type="image/png" href="./img/Logo_Concept.png">
    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

</head>

<body>
    <div id="loading-screen" style="display: none">
        <img src="img/loading.svg">
    </div>

    <nav class="navbar navbar-expand-sm">
        <div class="container-fluid">
            <img class="logo rounded float-start" src="">
            <p class="title-head">Calificaciones Monitoreos</p>
            <img class="logo-concept rounded float-end" src="./img/Logo_Concept.png">
            <a href="./inicio" class="btn btn-success">Ir a monitoreo</a>
            <a class="cerrar" href="./php/logout">Cerrar Sesión <i class="fas fa-sign-out-alt fa-lg" style="color: black;"></i></a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="mb-2">
            <input type="text" id="servicioCal" class="form-control" value=<?= $_GET['servicio']; ?> hidden>
        </div>
        <table class="table table-sm table-hover table-striped">
            <thead class="header-tabla">
                <tr>
                    <th>Asesor</th>
                    <th>Audio</th>
                    <th>Fecha llamada</th>
                </tr>
            </thead>
            <tbody id="tabla-calificaciones"></tbody>
        </table>
    </div>

    <!-- MODAL DETALLE CALIFICACIÓN -->
    <div class="modal fade" id="detalleModal" tabindex="-1" aria-labelledby="detalleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detalleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm table-hover table-striped table-bordered">
                        <thead class="header-tabla">
                            <tr class="text-center">
                                <th>Item</th>
                                <th>Katerine Sepulveda</th>
                                <th>Liliana Agudelo</th>
                                <th>Paulina Escobar</th>
                                <th>Kelly Cartagena</th>
                                <th>Leidy Orlas</th>
                                <th>Jacobo Aristizábal</th>
                                <th>Karol Londoño</th>
                                <th>Sandra Gutierrez</th>
                                <th>Lady Johana Ortega</th>
                                <th>Liliana Mesa</th>
                                <th>German Martinez</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-detalle"></tbody>
                    </table>
                    <h5>Comentarios</h5>
                    <div id="comentarios"></div>
                </div>
            </div>
        </div>
    </div>


    <!-- BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <!-- JAVASCRIPT -->
    <script src="./js/calificaciones.js"></script>
</body>

</html>