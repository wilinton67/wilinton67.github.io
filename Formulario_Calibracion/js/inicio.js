$(document).ready(function () {
    cargarServicios();

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


function alerta(icono, mensaje) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    Toast.fire({
        icon: icono,
        title: mensaje
    })
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
            $('#seleccionarEncuesta').html(response);
            $('#servicio').html(response);

            loadTablaEncuesta();
            cargarAudios();
        }

    });
}


function loadTablaEncuesta() {


    // $(".auditoria").hide();
    $("#formulario").show();
    $(".encuesta").show();
    $('.title-head').show();
    var tabla = $("#seleccionarEncuesta option:selected").data("tabla");

    var cliente = $("#seleccionarEncuesta option:selected").data("cliente");

    var imagen = './img/logo_' + cliente + '.png';

    var servicio = $("#seleccionarEncuesta option:selected").data("servicio");

    var postData = {
        encuesta: tabla
    }
    $.post('./php/cargar_encuesta.php', postData, function (response) {
        //console.log(response);
        $('#filas-encuesta').html(response);
        $('.contenedor-tabla').css({
            'background-image': 'url("' + imagen + '")',
            'background-position': 'center center',
            "background-size": "50% 50%",
            "background-repeat": "no-repeat",
            "background-attachment": "fixed",

        });
        $('.tabla').css("background-color", "#d0d0d0b4");
        $('.title-head').text(servicio.toUpperCase());
    })
}

$(document).on('change', '#seleccionarEncuesta', function () {
    loadTablaEncuesta();
    cargarAudios();
    $('#mostrarAudio').hide();
    var title = $('#seleccionarEncuesta').val();
    $('.title-head').html(title);
});

function tomarValores(i) {
    if ($('#logro' + i).val() == 'Si' || $('#logro' + i).val() == 'N/A') {
        var valor = parseFloat($('#peso' + i).text());
    } else {
        var valor = 0.0
    }

    return valor;
}

// $(document).on('change', "select[id^='logro']", function () {
//     var valorTotal = 0;
//     $("select[id^='logro']").each(function (index, element) {
//         var valor = tomarValores((index + 1));
//         valorTotal = parseFloat(valorTotal) + parseFloat(valor)
//     });
//     $("#nota").val(valorTotal);
// });


$(document).on('click', "#BtnEnviar", function () {
    var tabla = $("#tablaEncuesta");
    var filas = tabla.find("tbody tr");
    var datos = [];

    filas.each(function (index, fila) {
        if (!$(fila).hasClass('Titulo')) {
            var columnas = $(fila).find("td"); // Obtener todas las celdas de la fila
            var pregunta = columnas.eq(0).text(); // Obtener el texto de la primera celda (Nombre)
            var respuesta = $(fila).find("td:eq(1) select");
            var respuesta2 = respuesta.val();// Obtener el texto de la segunda celda (Edad)
            if (respuesta2 == '') {
                alerta('error', 'Faltan preguntas por responder en la encuesta');
                return;
            }
            var puntaje = columnas.eq(2).text();
            var peso = columnas.eq(3).text();
            var filaDatos = {
                pregunta: pregunta,
                respuesta: respuesta2,
                puntaje: puntaje,
                peso: peso
            }
            datos.push(filaDatos);
        }
    });


    var jsonDatos = JSON.stringify(datos);

    // if ($('#usuario').val() == '') {
    //     alerta('error', 'No se ha ingresado Usuario de red');
    //     return;
    // }

    if ($('#nombre').val() == '') {
        alerta('error', 'No se ha ingresado el nombre del asesor');
        return;
    }

    if ($('#fecha_llamada').val() == '') {
        alerta('error', 'No se ha ingresado fecha de la llamada');
        return;
    }

    if ($('#id_llamada').val() == '') {
        alerta('error', 'No se ha ingresado el id de la llamada');
        return;
    }
    if ($('#comentario').val() == '') {
        alerta('error', 'No se ha ingresado el comentario');
        return;
    }

    var postData = {
        usuario: $('#usuario').val(),
        nombre: $('#nombre').val(),
        id_html: $('#archivoHTML').val(),
        fecha_llamada: $('#fecha_llamada').val(),
        id_llamada: $('#id_llamada').val(),
        comentario: $('#comentario').val(),
        nota: $('#nota').val(),
        servicio: $('#seleccionarEncuesta').val(),
        respuestas: jsonDatos
    }

    $.post('./php/guardar_respuestas.php', postData, function (response) {
        console.log(response);
        if (response == 'Guardado correctamente') {
            Swal.fire({
                icon: 'success',
                title: response,
                showConfirmButton: true,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            vaciarCampos();
            cargarAudios();
        }
    });

});

$(document).on('click', "#BtnCancelar", function () {
    vaciarCampos()
});

function vaciarCampos() {
    $('#archivoHTML').html('');

    $("select[id^='logro']").each(function (index, element) {
        $("select[id^='logro" + index + "']").val('');
    });

    $('#usuario').val('');
    $('#nombre').val('');
    $('#fecha_llamada').val('');
    $('#id_llamada').val('');
    $('#comentario').val('');
    $('#nota').val('');
    $('#audio').val('');
    $('#mostrarAudio').html('');
    $('#Cliente').val('');
    $('#cedula').val('');

    cargarAudios();
}

//Funcion para cargar los datos del HTML Y del cliente en el INICIO
$(document).on('change', '#archivoHTML', function () {
    var selectedOption = $(this).find("option:selected").val();
    // Verificar si se seleccionó la opción "Selecciona una opción..."
    if (selectedOption === "1") {
        // No generar un enlace si se selecciona la opción predeterminada
        $('#mostrarAudio').hide();
        // Limpiar el contenido del div
    } else {
        postData = {
            audio: $('#archivoHTML').val()
        }

        $.post('./php/buscar_datos.php', postData, function (response) {
            if (response.includes('ERROR')) {
                // Maneja el caso de error si es necesario
            } else {
                var response = JSON.parse(response);

                $('#usuario').val(response.Usuario_asesor);
                $('#nombre').val(response.Nombre_asesor);
                $('#Cliente').val(response.Nombre_cliente);
                $('#cedula').val(response.Cedula_cliente);



                const mostrarModalBtn = document.getElementById("mostrarModal");
                const clienteModal = new bootstrap.Modal(document.getElementById('clienteModal')); // Inicializa el modal
                const cerrarModalBtn = document.getElementById("close");

                mostrarModalBtn.addEventListener("click", function () {
                    clienteModal.show();
                    $('#nombreCliente').val(response.Nombre_cliente);
                    $('#cedulaCliente').val(response.Cedula_cliente);
                    // Muestra el modal al hacer clic en el botón
                });

                cerrarModalBtn.addEventListener("click", function () {
                    clienteModal.hide(); // Cierra el modal al hacer clic en el botón "Cerrar"
                });


                // Formatea la fecha en el formato "yyyy-MM-dd"
                var fechaHora = response.Fecha_Llamada;
                var fecha = new Date(fechaHora);
                var año = fecha.getFullYear();
                var mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
                var dia = fecha.getDate().toString().padStart(2, '0');
                var fechaFormateada = año + "-" + mes + "-" + dia;

                $('#fecha_llamada').val(fechaFormateada);
                $('#id_llamada').val(response.Id_llamada);
                var servicio = $('#seleccionarEncuesta').val();

                // Crear el enl(ace y asignarle un evento de clic para abrir la ventana emergente
                if (selectedOption.includes('.html')) {
                    var linkHTML = $(`<a href='./adjuntos/${servicio}/${response.Nombre_Audio}' target='_blank' style='white-space: nowrap;'></a>`);
                    linkHTML[0].innerHTML = `${response.Nombre_Audio}`;


                    linkHTML.click(function (event) {
                        event.preventDefault(); // Evitar que el enlace abra en la pestaña actual
                        var url = $(this).attr('href');
                        var windowFeatures = "width=700,height=500"; // Puedes ajustar el tamaño aquí
                        window.open(url, "", windowFeatures);
                    });
                } else {
                    var linkHTML = `<audio controls controlsList="nodownload"><source src='./adjuntos/${servicio}/${response.Nombre_Audio}' type='audio/mpeg'></audio>`;
                }




                if (typeof response.Nombre_Audio === 'undefined') {
                    $('#mostrarAudio').hide();
                } else {
                    $('#mostrarAudio').html(linkHTML);
                    $('#mostrarAudio').show(); // Mostrar el elemento aquí
                }
            }
        });
    }
});





function cargarAudios() {

    var postData = {
        servicio: $('#seleccionarEncuesta').val()
    }
    $.post('./php/cargar_audios.php', postData, function (response) {
        // console.log(response);
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

            $('#archivoHTML').html(response);
        }

    });
}



$(document).on('click', '#calificaciones', function () {
    var servicio = $('#seleccionarEncuesta').val();
    window.location.href = './calificaciones.php?servicio=' + servicio;
})