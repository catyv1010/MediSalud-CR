// validaciones del formulario de recuperar acceso

$(function () {

    $("#form-recuperar").validate({
        rules: {
            correo: { required: true, email: true }
        },
        messages: {
            correo: { required: "Ingrese su correo electrónico", email: "El correo no tiene un formato válido" }
        }
    });

});
