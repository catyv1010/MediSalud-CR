// validaciones del formulario de iniciar sesion

$(function () {

    $("#form-login").validate({
        rules: {
            cedula: { required: true },
            contrasena: { required: true }
        },
        messages: {
            cedula: { required: "Ingrese su cédula o correo electrónico" },
            contrasena: { required: "Ingrese su contraseña" }
        }
    });

});
