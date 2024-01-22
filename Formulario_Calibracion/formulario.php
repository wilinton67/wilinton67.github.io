<?php
session_start();

// if (!$_SESSION['Nombre']) {
//     header('location: index');
// } else if (isset($_SESSION['Perfil']) && $_SESSION['Perfil'] == 'Monitoreo') {
//     header('Location: inicio');
// }
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formulario Redes Sociales</title>
    <!-- BOOTSTRAP 5 -->
    <link href="./css/bootstrap/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="./css/formulario.css">
    <link rel="icon" type="image/png" href="./img/Logo_Concept.png">
    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

</head>

<body class="bg-light">

    <header class="pt-1">
        <nav class="navbar navbar-expand-sm" style="height: 60px;">
            <div class="container-fluid">
                <img class="logo-concept rounded float-end" width="120" src="./img/Logo_Concept.png">

                <a class="cerrar text-dark text-decoration-none btn btn-success text-white" href="./inicio">Ir a Formulario de Calidad</a>
                <a class="cerrar text-dark text-decoration-none" href="./php/logout.php">Cerrar Sesión <i class="fas fa-sign-out-alt fa-lg" style="color: black;"></i></a>
            </div>
        </nav>
    </header>

    <div class="container">
        <div class="card shadow mt-3">
            <div class="card-body">
                <h4>Formulario</h4>

                <form id="formulario" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-2">
                                <label for="asesorList" class="form-label">Nombre Asesor:</label>
                                <input class="form-control" list="asesorOptions" id="asesorList" name="asesorList" placeholder="Escribe para buscar..." autocomplete="off">
                                <datalist id="asesorOptions">
                                </datalist>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mb-2">
                                <label for="usuarioAsesor" class="form-label">Usuario Asesor:</label>
                                <input type="text" id="usuarioAsesor" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-2">
                                <label for="nombreCliente" class="form-label">Nombre Cliente:</label>
                                <input type="text" id="nombreCliente" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-2">
                                <label for="cedulaCliente" class="form-label">Cedula Cliente:</label>
                                <input type="number" id="cedulaCliente" class="form-control">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-2">
                                <label for="categoria" class="form-label">Seleccione Categoría Monitoreo</label>
                                <select id="categoria" name="categoria" class="form-select form-select-sm">
                                </select>
                            </div>
                        </div>


                        <div class="mb-2">
                            <label for="archivoHTML" class="form-label">Audio (mp3)</label>
                            <input type="file" id="archivoHTML" name="archivoHTML" class="form-control form-control-sm">
                        </div>





                        <div class="col-6">
                            <div class="mb-2">
                                <label for="fechaLlamada" class="form-label">Fecha Contacto:</label>
                                <input type="date" id="fechaLlamada" name="fechaLlamada" class="form-control">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mb-2">
                                <label for="idLlamada" class="form-label">Id Contacto:</label>
                                <input type="text" id="idLlamada" class="form-control" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-grid gap-2 col-4 mx-auto">
                        <button class="btn btn-sm btn-success" type="submit">Subir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- BOOTSTRAP -->
    <script src="./js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- JQUERY -->
    <script src="./js/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="./js/formulario.js"></script>
</body>

</html>