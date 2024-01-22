<?php
session_start();
if (isset($_SESSION['Usuario'])) {
    header('location: inicio.php');
}

?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" type="image/png" href="img/Logo_Concept.png" />
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="css/index.css">

    <!-- <script src="Scripts/jquery-3.5.1.min.js" type="text/javascript"></script> -->

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body id="body">

    <img src="img/Fondo.png" class="Image_fondo" height="100%" />
    <div style="width: 100%;">
        <div class="form col-3">
            <div class="text-center">
                <img src="img/Logo_Concept.png" class="Image_Logo" />
            </div>
            <div class="mb-3">
                <input type="text" id="TxtUsuario" class="form-control" placeholder="Ingrese usuario" autocomplete="off" required />
            </div>
            <div class="mb-3">
                <input type="password" id="TxtPassword" class="form-control" placeholder="Ingrese contraseña" autocomplete="off" required />
            </div>
            <div class="col-6">
                <button id="BtnIngresar" class="btn btn-primary text-white btn-block col-10">Ingresar</button>
            </div>
        </div>
    </div>



    <!--MODAL CAMBIO CONTRASEÑA-->
    <div class="modal fade" id="modalCambioContraseña" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalCambioContraseña" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo-modal">Cambiar contraseña</h5>
                    <div class="btn-group" role="group">
                        <!-- <button type="button" class="btn mx-0" id="AbrirAdres">Abrir Link</button> -->
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="col mb-3" style="text-align: center;">
                            <label class='label-login'>Contraseña:
                                <input type="password" class="form-control" id="txtModalPass" autocomplete="new-password">
                            </label>
                        </div>
                        <div class="col mb-3" style="text-align: center;">
                            <label class='label-login'>Confirmar contraseña:
                                <input type="password" class="form-control" id="txtModalConfirmPass" autocomplete="new-password">
                            </label>

                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="text-align: center; justify-content: center; align-items: center;">
                    <button type="button" class="btn col-6 boton-enviarToken" id="btnCambiar">Cambiar contraseña</button>
                </div>
            </div>
        </div>
    </div>

    <!-- BOOTSTRAP -->
    <script src="./js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- JQUERY -->
    <script src="./js/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <!-- JAVASCRIPT -->
    <script src="./js/sweetalert2@11.js"></script>
    <script src="./js/index.js"></script>

</body>

</html>