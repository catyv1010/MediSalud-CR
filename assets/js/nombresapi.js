// trae el nombre del api de cedulas y lo pone en el formulario
// la usan el registro y mi perfil

function BloquearNombre() {
    $("#nombre").prop("readonly", true);
    $("#nombre").css("background-color", "#d9dde28d");
    $("#aviso-nombre").hide();
}

function DesbloquearNombre() {
    $("#nombre").prop("readonly", false);
    $("#nombre").css("background-color", "");
    $("#aviso-nombre").show();
}

function ConsultarNombreAPI() {
    let cedula = $("#cedula").val();

    if (cedula.length < 9) {
        $("#nombre").val("");
        BloquearNombre();
        return;
    }

    $.ajax({
        type: "GET",
        url: "https://apis.gometa.org/cedulas/" + cedula,
        dataType: "json",
        timeout: 5000,
        success: function (data) {
            if (data && data.nombre) {
                $("#nombre").val(data.nombre);
                BloquearNombre();
            } else {
                // la cedula no aparece en el api, se escribe a mano
                DesbloquearNombre();
            }
        },
        error: function () {
            // sin conexion o api caida: se permite escribir el nombre a mano
            DesbloquearNombre();
        }
    });
}

$(function () {

    // aviso que se muestra solo cuando hay que escribir el nombre a mano
    $("#nombre").after(
        '<small id="aviso-nombre" class="text-muted" style="display:none;">' +
        'No se pudo consultar la cédula en línea. Escriba el nombre completo.' +
        "</small>"
    );

    // en el registro llega vacio y lo llena el api, en mi perfil ya viene con dato
    if ($("#nombre").val() == "") {
        BloquearNombre();
    }

    $("#cedula").on("keyup", ConsultarNombreAPI);

});
