$(document).on("change", "select[id^='logro']", function () {

    let grupo = $(this).parent().parent().children().eq(4).text();
    monitoreoCalidad(grupo, 0, 0);

});


function monitoreoCalidad(grupo, cambio) {

    // let grupo = $(this).parent().parent().children().eq(4).text();

    var resume_table = document.getElementById("filas-encuesta");
    var cantidadNA = 0; var cantidadAtributos = 0; var valorPesoGrupo = ""; var total = 0; var pesoADividir = 0;
    var errorCritico = false;

    //CICLO PARA DETECTAR EN QUE GRUPO SE HIZO EL CAMBIO DE LA LISTA Y DIVIDE LOS PESOS
    for (var i = 0, row; row = resume_table.rows[i]; i++) {

        var idSelect = $("#" + "logro" + (i + 1) + "-" + grupo);

        if (idSelect.length > 0) {
            if (idSelect.val() == "N/A") {
                cantidadNA++; //CUENTA LA CANTIDAD DE N/A EN EL GRUPO
                pesoADividir = pesoADividir + parseFloat(row.cells[2].innerText);
            }

        }

        if (row.cells[4].innerText == grupo)
            cantidadAtributos++; //CUENTA LA CANTIDAD DE ATRIBUTOS EN EL GRUPO

        if (row.cells[4].innerText == "Titulo-" + grupo)
            valorPesoGrupo = row.cells[2].innerText; //ASIGNA EL VALOR DEL GRUPO

    }

    var pesoActual = pesoADividir / (cantidadAtributos - cantidadNA);
    var valorSi = 0; var valorNo = 0;

    //CICLO PARA CAMBIAR LOS VALORES SEGÚN EL DATO SELECCIONADO
    for (var i = 0, row; row = resume_table.rows[i]; i++) {

        if (row.cells[4].innerText == grupo) {
            var idSelect = $("#" + "logro" + (i + 1) + "-" + grupo);
            var idPeso = $("#" + "peso" + (i + 1));
            var idValor = $("#" + "valor" + (i + 1));

            if (idSelect.val() == "N/A") {
                idPeso.text("0");
                idValor.text("0");
            }

            else if (idSelect.val() == "Si") {
                if (idPeso.text() == 0) //VALIDA SI LA RESPUESTA SI ESTÁ EN PESO 0 Y ASÍ VOLVER A LLAMAR LA FUNCIONA PARA QUE CAMBIE LOS CAMPOS DE ARRIBA
                {
                    valorSi = (parseFloat(valorPesoGrupo) / (cantidadAtributos - cantidadNA)).toFixed(2);
                    idPeso.text(valorSi);
                    idValor.text(valorSi);
                    // total = 0;
                    monitoreoCalidad(grupo, valorSi); // LLAMAMOS A LA FUNCION Y LE MANDAMOS EL VALOR EN EL QUE DEBEN DE QUEDAR LOS OTROS SI O NO

                } else {
                    if (cambio != 0) // VALIDAMOS SI ENTRÓ A LA FUNCIÓN CON 0 U OTRO VALOR
                    {
                        idPeso.text(cambio);
                        idValor.text(cambio);
                    } else {
                        valorSi = (parseFloat(idPeso.text()) + parseFloat(pesoActual)).toFixed(2);
                        idPeso.text(valorSi);
                        idValor.text(valorSi);
                    }

                }

            } else if (idSelect.val() == "No") {

                if (idPeso.text() == 0) //VALIDA NO LA RESPUESTA SI ESTÁ EN PESO 0 Y ASÍ VOLVER A LLAMAR LA FUNCIONA PARA QUE CAMBIE LOS CAMPOS DE ARRIBA
                {
                    valorNo = (parseFloat(valorPesoGrupo) / (cantidadAtributos - cantidadNA)).toFixed(2);
                    idPeso.text(valorNo);
                    idValor.text(valorNo);
                    monitoreoCalidad(grupo, valorNo); // LLAMAMOS A LA FUNCION Y LE MANDAMOS EL VALOR EN EL QUE DEBEN DE QUEDAR LOS OTROS SI O NO

                } else {
                    if (cambio != 0) // VALIDAMOS SI ENTRÓ A LA FUNCIÓN CON 0 U OTRO VALOR
                    {
                        idPeso.text(cambio);
                        idValor.text("0");
                    } else {
                        idPeso.text((parseFloat(idPeso.text()) + parseFloat(pesoActual)).toFixed(2));
                        idValor.text("0");
                    }
                }

                if (row.cells[5].innerText == "Si")
                    errorCritico = true;


            } else if (idSelect.val() == "") {
                idPeso.text((parseFloat(idPeso.text()) + parseFloat(pesoActual)).toFixed(2));
                idValor.text("0");
            }

        }

    }

    for (var i = 0, row; row = resume_table.rows[i]; i++) {

        if (row.cells[3].innerText != "")
            total += parseFloat(row.cells[3].innerText);
    }

    if (errorCritico == true)
        total = 0;
    else if (total > 100)
        total = 100;
    else if (total < 0)
        total = 0;

    $("#nota").val(total.toFixed(2));

}