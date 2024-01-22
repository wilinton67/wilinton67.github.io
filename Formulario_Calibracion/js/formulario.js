
// Variable de bandera para determinar qué función debe ejecutarse
var ejecutarFuncionAudio = false;

// Agregar un evento submit al formulario
$('#formulario').submit(function (e) {
    e.preventDefault();

    // Obtener el valor seleccionado en el campo "Categoría"

    // Realizar la lógica para enviar el formulario de "Redes Sociales" aquí
    // Obtener el archivo HTML seleccionado
    let archivoHTML = $('#archivoHTML').prop("files")[0];
    // Crear un nuevo objeto FormData
    let formData = new FormData();

    // Agregar el archivo HTML al objeto FormData
    formData.append("archivoHTML", archivoHTML);

    // Agregar otros campos al objeto FormData
    formData.append('asesor', $('#asesorList').val());
    formData.append('usuarioAsesor', $('#usuarioAsesor').val());
    formData.append('fechaLlamada', $('#fechaLlamada').val());
    formData.append('idLlamada', $('#idLlamada').val());
    formData.append('nombreCliente', $('#nombreCliente').val());
    formData.append('cedulaCliente', $('#cedulaCliente').val());
    formData.append('servicio', $('#categoria').val());

    if (!validarVacio('asesorList', 'El asesor') ||
        !validarVacio('nombreCliente', 'El nombre del cliente') ||
        !validarVacio('cedulaCliente', 'La cedula del cliente') ||
        !validarVacio('archivoHTML', 'El archivo HTML') ||
        !validarVacio('fechaLlamada', 'La fecha del contacto') ||
        !validarVacio('idLlamada', 'El id del contacto')
    ) {
        return; // Si algún campo está vacío, detener el envío del formulario
    }
    // Realizar la solicitud AJAX para enviar el formulario
    $.ajax({
        url: './php/guardar_audio.php',
        type: 'post',
        contentType: false,
        processData: false,
        data: formData,
        success: function (response) {
            //console.log(response);
            if (response == "Archivo subido correctamente") {
                Swal.fire({
                    icon: 'success',
                    title: 'Archivo cargado correctamente!',
                    showConfirmButton: false,
                    timer: 1500
                });

                // Limpiar los campos del formulario solo si la respuesta es "HTML subido correctamente"
                $('#audio').val('');
                $('#archivoHTML').val('');
                $('#asesorList').val('');
                $('#nombreCliente').val('');
                $('#cedulaCliente').val('');
                $('#usuarioAsesor').val('');
                $('#fechaLlamada').val('');
                $('#idLlamada').val('');
                $('#categoria').val('redes_sociales');
            } else if (response == "El archivo Archivo ya existe.") {
                Swal.fire({
                    icon: 'error',
                    title: '¡El archivo ya existe: selecciona uno diferente!',
                    confirmButtonText: 'Aceptar',
                    //timer: 1500
                });
            } else if (response == "Archivo no permitido") {
                Swal.fire({
                    icon: 'error',
                    title: '¡Archivo no permitido: debe ser HTML o Audio ',
                    confirmButtonText: 'Aceptar',
                    //timer: 1500
                });
            }
        }
    });


});

// Agregar un evento change al campo "Categoría"

function cargarNombreAsesor() {
    $.get('./php/cargar_asesores.php', function (response) {
        //console.log(response);return;
        let datos = JSON.parse(response);

        let template = '';

        datos.forEach(dato => {
            template += `<option>${dato.Nombre}</option>`;
        });

        $('#asesorOptions').html(template)

    })
}

function traerUsuarioAsesor(nombre) {
    $.post('./php/cargar_usuario.php', { nombre }, function (response) {
        // console.log(response);return;
        $('#usuarioAsesor').val(response);
    })
}

$('#asesorList').change(function () {
    let nombre = $('#asesorList').val();
    traerUsuarioAsesor(nombre);
})


function validarVacio(campo, nombre = campo) {
    if ($(`#${campo}`).val() == "") {
        $(`#${campo}`).focus();
        setTimeout(() => {
            if ($(`#${campo}`).val() == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: `${nombre} es requerid@`
                });
            }
        }, 100);
        return false;
    }
    return true;
}



function cargarServicios() {

    $.post('./php/cargar_servicios.php', function (response) {

        if (response.includes('ERROR')) {
            Swal.fire({
                icon: 'error',
                title: 'No se pudo cargar los nombres',
                showConfirmButton: true,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        } else {
            $('#categoria').html(response);
            cargarAsesores();

        }

    });
}

$(document).ready(function () {
    cargarServicios();

    // cargarAudios();
    // loadTablaEncuesta();
    // var title = $('#seleccionarEncuesta').val();

    var screen = $('#loading-screen');
    configureLoadingScreen(screen);

    function configureLoadingScreen(screen) {
        $(document)
            .ajaxStart(function () {
                screen.fadeIn();
            })
            .ajaxStop(function () {
                screen.fadeOut();
            });
    }

})



$(document).on('change', '#categoria', function (e) {
    //e.preventDefault();
    cargarAsesores();

});


function cargarAsesores() {

    var cliente = $("#categoria option:selected").data("cliente");

    var postData = {
        cliente: cliente
    }

    $.post('./php/cargar_asesores.php', postData, function (response) {

        if (response.includes('ERROR')) {
            Swal.fire({
                icon: 'error',
                title: 'Error en la base de datos de los asesores.',
                showConfirmButton: false,
                timer: 1500
            })

        } else {
            $('#asesorOptions').html(response);
        }

    })

}