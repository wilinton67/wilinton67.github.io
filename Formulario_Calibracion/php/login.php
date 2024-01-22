<?php
include_once("../config/config.php");

$usuario = $_POST['usuario'];
$password = $_POST['password'];

try {
    $url = "http://10.180.139.200/ActiveDirectory.asmx?wsdl";
    // $url = "http://179.50.77.57/ActiveDirectory.asmx?wsdl";

    $parametro = array(
        "usuario"    => $usuario,
        "contraseña" => $password
    );

    $client = new SoapClient($url);
    $result = $client->AutenticarUsuarioConceptBPO($parametro);

    if (isset($result->AutenticarUsuarioConceptBPOResult)) {

        $user = $result->AutenticarUsuarioConceptBPOResult;

        if ($user == true) {

            $sql = "SELECT Id, Usuario, Password, Nombre, Documento, Perfil, Cliente
                    FROM Calibracion_Usuarios 
                    WHERE Usuario = :usuario";

            $query = $conexion->prepare($sql);

            $query->bindParam(':usuario', $usuario);

            $query->execute();

            if ($query->rowCount() > 0) {
                $result = $query->fetch(PDO::FETCH_ASSOC);
                session_start();
                $_SESSION['Documento'] = $result['Documento'];
                $_SESSION['Nombre']    = $result['Nombre'];
                $_SESSION['Usuario']   = $result['Usuario'];
                $_SESSION['Perfil']    = $result['Perfil'];
                $_SESSION['Cliente']    = $result['Cliente'];
                echo "Success";
                return;
            } else {
                echo "Permisos";
            }
        }
    } else {
        $sql = "SELECT Id, Usuario, Password, Nombre, Documento, Cambio_password, Perfil, Cliente 
                FROM Calibracion_Usuarios
                WHERE Usuario = :usuario AND Estado = 'Activo'";

        $query = $conexion->prepare($sql);

        $query->bindParam(':usuario', $usuario);

        if ($query->execute()) {

            if ($query->rowCount() > 0) {

                $result = $query->fetch(PDO::FETCH_ASSOC);

                if (trim($result['Cambio_password']) == "Si" && (trim($result['Password']) == $password || password_verify(trim($password), $result['Password']))) {
                    session_start();
                    $_SESSION['Usuario'] = $usuario;

                    echo "Cambio de contraseña";
                    return;
                }

                if (password_verify(trim($password), $result['Password'])) {

                    session_start();
                    $_SESSION['Documento'] = $result['Documento'];
                    $_SESSION['Nombre']    = $result['Nombre'];
                    $_SESSION['Usuario']   = $result['Usuario'];
                    $_SESSION['Perfil']   = $result['Perfil'];
                    $_SESSION['Cliente']   = $result['Cliente'];
                    echo "Success";
                } else {
                    echo "error";
                    return;
                }
            }
        }
    }
} catch (\Throwable $e) {
    echo ("ERROR: " . $e->getMessage());
}

$query->closeCursor();
$query = null;
$conexion = null;
