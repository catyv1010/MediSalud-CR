// consulta el nombre en el api de cedulas y lo precarga en el formulario
// la usan el registro y la pantalla de mi perfil, para no repetir la funcion

function ConsultarNombreAPI()
{
    let cedula = $("#cedula").val();
    $("#nombre").val("");

    if (cedula.length >= 9)
    {
        $.ajax({
            type: 'GET',
            url: 'https://apis.gometa.org/cedulas/' + cedula,
            dataType: 'json',
            success: function (data) {
                $("#nombre").val(data.nombre);
            }
        });
    }
}

$(function () {

    $("#nombre").prop("readonly", true);
    $("#nombre").css("background-color", "#d9dde28d");

    $("#cedula").on("keyup", ConsultarNombreAPI);

});
