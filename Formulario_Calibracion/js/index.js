function message(tipo, dato) {

    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    if (tipo == "error") {
        Toast.fire({
            icon: 'error',
            title: dato
        })

    } else if (tipo == "success") {
        Toast.fire({
            icon: 'success',
            title: dato
        })
    } else {
        Toast.fire({
            icon: 'warning',
            title: dato
        })
    }


}

$(document).on('click', '#BtnIngresar', function () {

    if ($('#TxtUsuario').val() == "") {
        message('error', 'El campo Usuario se encuentra vacío.');
        $('#TxtUsuario').focus();
        return;
    }

    if ($('#TxtPassword').val() == "") {
        message('error', 'El campo Contraseña se encuentra vacío.');
        $('#TxtPassword').focus();
        return;
    }

    var postData = {
        usuario: $('#TxtUsuario').val(),
        password: $('#TxtPassword').val()
    }


    $.post('./php/login.php', postData, function (response) {
        // console.log(response);return;
        if (response == "Success") {
            window.location.href = "inicio";
            return;
        }

        if (response == "Cambio de contraseña") {
            $('#modalCambioContraseña').modal("show");
            return;
        }

        if (response == "No existe") {
            message('error', 'Usuario o contraseña incorrecto.');
            $('#TxtUsuario').focus();
            return;

        } else {
            message('error', 'Usuario o contraseña incorrecto.');
            $('#TxtUsuario').focus();
            return;
        }
    })


})

$("#body").keyup(function (event) {
    if (event.keyCode === 13) {
        $("#BtnIngresar").click();
    }
});


$(document).on('click', '#btnCambiar', function () {

    if ($('#txtModalPass').val() == "") {
        message('warning', 'El campo Contraseña está vacío.');
        $('#txtModalPass').focus();
        return;
    }

    if ($('#txtModalConfirmPass').val() == "") {
        message('warning', 'El campo Confirmar contraseña está vacío.');
        $('#txtModalConfirmPass').focus();
        return;
    }

    if ($('#txtModalPass').val().length < 8) {
        message('warning', 'La contraseña debe tener mínimo 8 caracteres.');
        $('#txtModalPass').focus();
        return;
    }

    if ($('#txtModalConfirmPass').val().length < 8) {
        message('warning', 'La contraseña debe tener mínimo 8 caracteres.');
        $('#txtModalConfirmPass').focus();
        return;
    }

    const hasNumber = str => str.toString().search(/[\d]/) >= 0;

    if (hasNumber($('#txtModalPass').val()) == false) {
        message('warning', 'La contraseña debe de tener al menos un número.');
        $('#txtModalPass').focus();
        return;
    }

    if ($('#txtModalPass').val() != $('#txtModalConfirmPass').val()) {
        message('warning', 'Las contraseñas no coinciden.');
        $('#txtModalPass').focus();
        return;
    }

    Swal.fire({
        title: '¿Estas seguro?',
        text: "Que deseas modificar esta contraseña",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#7bb024',
        cancelButtonColor: '#adb5bd',
        confirmButtonText: 'Si, modificar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {

            let postData = {
                password: $('#txtModalPass').val().trim()
            }

            $.post('./php/cambiarPassword.php', postData, function (response) {
                // console.log(response);return;          

                if (response == "Error" || response.includes('ERROR')) {
                    message('error', 'Error en la base de datos.');
                    return;
                }

                if (response == "success") {
                    $('#TxtUser').val('');
                    $('#TxtPass').val('');
                    $('#modalCambioContraseña').modal("hide");
                    $('#TxtPassword').val('');
                    message('success', 'Contraseña actualizada exitosamente.');
                }

            })

        }
    })

})