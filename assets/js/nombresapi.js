// consulta el nombre en el api de cedulas y lo precarga en el formulario
// la usan el registro y la pantalla de mi perfil, para no repetir la funcion
//
// el campo nombre arranca bloqueado para que lo llene el api,
// pero si el api no responde (sin internet o servicio caido) se desbloquea
// para que la persona lo pueda escribir a mano y el registro no se trabe

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

    // en el registro el campo llega vacio: se bloquea para que lo llene el api.
    // en mi perfil ya viene con el nombre guardado, ahi se deja editable para
    // que la persona pueda corregirlo sin tener que borrar y escribir la cedula
    if ($("#nombre").val() == "") {
        BloquearNombre();
    }

    $("#cedula").on("keyup", ConsultarNombreAPI);

});
