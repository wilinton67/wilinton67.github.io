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

function verCalificaciones() {
   
    $.post('./php/ver_calificaciones.php', function (response) {
        //console.log(response);return;
        if (response.includes("ERROR:")) {
            alerta("error", "Algo salió mal al mostrar los resultados");
            return;
        }

        let datos = JSON.parse(response);
        let template = '';

        datos.forEach(dato => {
            template += `<tr data-id="${dato.Id}">
                            <td>${dato.Nombre_asesor}</td>
                            <td>${dato.Nombre_Audio}</td>
                            <td>${dato.Fecha_llamada}</td>
                        </tr>`;
        });

        $('#tabla-calificaciones').html(template);
    })
}

function verDetalleCal(id) {
    $.get('./php/detalle_calificacion.php?id=' + id, function (response) {
        //console.log(response);return;
        if (response.includes("ERROR:")) {
            alerta("error", "Algo salió mal al mostrar detalle");
            return;
        }

        let datos = JSON.parse(response);
        //console.log(response);
        let template = '';

        datos.forEach(dato => {
            template += `<tr>
                            <td>${dato.Pregunta}</td>
                            <td class="text-center">${dato['Katerine Sepulveda'] == null ? '' : dato['Katerine Sepulveda']}</td>
                            <td class="text-center">${dato['Liliana Agudelo'] == null ? '' : dato['Liliana Agudelo']}</td>
                            <td class="text-center">${dato['Paulina Escobar'] == null ? '' : dato['Paulina Escobar']}</td>
                            <td class="text-center">${dato['Kelly Cartagena'] == null ? '' : dato['Kelly Cartagena']}</td>
                            <td class="text-center">${dato['Leidy Orlas'] == null ? '' : dato['Leidy Orlas']}</td>
                            <td class="text-center">${dato['Jacobo Aristizabal'] == null ? '' : dato['Jacobo Aristizabal']}</td>
                            <td class="text-center">${dato['Karol Londono'] == null ? '' : dato['Karol Londono']}</td>
                            <td class="text-center">${dato['Sandra Gutierrez'] == null ? '' : dato['Sandra Gutierrez']}</td>
                            <td class="text-center">${dato['Lady Johana Ortega'] == null ? '' : dato['Lady Johana Ortega']}</td>
                            <td class="text-center">${dato['Liliana Mesa'] == null ? '' : dato['Liliana Mesa']}</td>,
                            <td class="text-center">${dato['German Martinez'] == null ? '' : dato['German Martinez']}</td>
                        </tr>`;
        });

        $('#tabla-detalle').html(template);
    })
}

function verComentariosCal(id) {
    $.get('./php/comentario_calificacion.php?id=' + id, function (response) {
        //console.log(response);return;
        if (response.includes("ERROR:")) {
            alerta("error", "Algo salió mal al mostrar detalle");
            return;
        }

        let datos = JSON.parse(response);
        let template = '';

        datos.forEach(dato => {
            template += `<div class="py-3">
                            <label><b>${dato.Nombre_revisor}</b> - <b>Nota</b>: ${dato.Nota}</label>
                            <textarea rows="6" class="form-control" readonly>${dato.Comentario.trim()}</textarea>
                        </div>`;
        });

        $('#comentarios').html(template);

    })
}

$(document).ready(function () {
    verCalificaciones();

    $(document).on('click', '#tabla-calificaciones tr', function () {
        let id = $(this).data('id');
        let asesor = $(this).find('td:first').text();

        $('#detalleModalLabel').text(asesor);
        verDetalleCal(id);
        verComentariosCal(id);
        $('#detalleModal').modal('show');
    })
})