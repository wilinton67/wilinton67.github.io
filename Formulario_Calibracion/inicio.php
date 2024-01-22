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
    <title>Calidad Redes Sociales</title>
    <!-- BOOTSTRAP 5 -->
    <link href="./css/bootstrap/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" href="./css/inicio.css">
    <link rel="icon" type="image/png" href="./img/Logo_Concept.png">
    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
</head>

<body>
    <div id="loading-screen" style="display: none">
        <img src="img/loading.svg">
    </div>

    <header class="pt-1">
        <nav class="navbar navbar-expand-sm" style="height: 60px;">
            <div class="container-fluid">

                <p class="title-head mx-auto"></p>
                <img class="logo-concept rounded mx-auto" src="./img/Logo_Concept.png">

                <a class="cerrar" href="./php/logout.php">Cerrar Sesión <i class="fas fa-sign-out-alt fa-lg" style="color: black;"></i></a>

            </div>
        </nav>
    </header>
    <div class="row main-content">
        <div class="col-12 encuesta">

            <div class="table-responsive contenedor-tabla container-fluid mt-2">

                <table id="tablaEncuesta" class="table table-hover table-sm tabla">
                    <thead class="text-dark">
                        <tr class="columnas">
                            <th>ATRIBUTOS Y/O COMPORTAMIENTOS DESEADOS</th>
                            <th>SI/NO/NA</th>
                            <th>PESO</th>
                            <th>VALOR</th>
                        </tr>
                    </thead>
                    <tbody id="filas-encuesta">
                    </tbody>
                </table>

            </div>
        </div>
        <div class="form mt-0">
            <div class="col-12 mb-4 mx-auto">
                <div class="col-8 mb-2">
                    <label for="seleccionarEncuesta" class="stylesLabels">Encuesta:</label>
                    <select name="seleccionarEncuesta" class="form-control stylesTextbox" id="seleccionarEncuesta" autocomplete="off">
                    </select>
                </div>
            </div>
            <div class="col-10 mb-2 mt-3">
                <div class="col-12 mb-2">
                    <label for="motivo" class="stylesLabels">Adjunto:</label>
                    <select type="text" name="archivoHTML" class="form-control stylesTextbox" id="archivoHTML" autocomplete="off">
                        <option value="1">Selecciona una opción...</option>
                    </select>
                </div>

                <div class="col-6 mb-1" id='mostrarAudio'></div>

                <label for="nombre" class="stylesLabels">Asesor:</label>
                <input type="text" class="form-control stylesTextbox" name="nombre" id="nombre" autocomplete="off" readonly disabled>
            </div>
            <div class="row ">
                <div class="col-4 mb-2">
                    <label for="nota" class="stylesLabels">Nota:</label>
                    <input type="text" class="form-control stylesTextbox" name="nota" id="nota" readonly autocomplete="off">
                </div>
                <div class="col-7 mb-2">
                    <label for="usuario" class="stylesLabels">Usuario de Red:</label>
                    <input type="text" name="usuario" class="usuario" id="usuario" autocomplete="off" readonly disabled>
                </div>
            </div>

            <button id="mostrarModal" class="btn btn-success mt-2">Mas Información</button>

            <!-- Modal -->
            <div class="modal fade" id="clienteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Información adiccional</h5>
                            <button type="button" class="btn-close" id="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="formularioCliente">
                                <div class="form-group">
                                    <label for="nombreCliente" class="stylesLabels">Nombre Cliente:</label>
                                    <input type="text" class="form-control" id="nombreCliente" name="nombreCliente" readonly>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="cedulaCliente" class="stylesLabels">Cédula Cliente:</label>
                                    <input type="text" class="form-control" id="cedulaCliente" name="cedulaCliente" readonly>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="id_llamada" class="stylesLabels">ID Chat:</label>
                                    <input type="text" class="form-control" id="id_llamada" name="id_llamada" readonly>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="fecha_llamada" class="stylesLabels">Fecha Chat:</label>
                                    <input type="date" class="form-control stylesTextbox" name="fecha_llamada" id="fecha_llamada" autocomplete="off" readonly>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-3">
                <label for="comentario" class="">Comentario:</label>
                <textarea type="text" name="comentario" class="form-control" rows="2" id="comentario" placeholder="Ingresa un comentario" autocomplete="off"></textarea>
            </div>
            <div class="col-12 mt-2 mb-2 mx-auto">
                <button class="btn btn-success mx-auto" id="BtnEnviar">Aceptar</button>
                <button class="btn btn-success mx-auto" id="BtnCancelar">Cancelar</button>
                <a id="calificaciones" class="btn btn-success">Calificaciones</a>
            </div>

            <?php
            if ($_SESSION['Perfil'] == 'Preparador') {
                echo '<a class="cerrar text-dark text-decoration-none btn btn-success text-white me-2" href="./formulario">Cargar archivo</a>';
            }
            ?>



        </div>
    </div>

    <!-- BOOTSTRAP -->
    <script src="./js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- JQUERY -->
    <script src="./js/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <!-- JAVASCRIPT -->
    <script src="./js/sweetalert2@11.js"></script>
    <script src="./js/respuestas.js"></script>
    <script src="./js/inicio.js"></script>
</body>

</html>