// validaciones del formulario de registro de pacientes

$(function () {

    $("#form-registro").validate({
        rules: {
            cedula: { required: true, maxlength: 20 },
            nombre: { required: true },
            correo: { required: true, email: true },
            contrasena: { required: true, minlength: 6, maxlength: 20 },
            contrasena_confirmar: { required: true, equalTo: "#contrasena" }
        },
        messages: {
            cedula: { required: "Ingrese su cédula", maxlength: "Máximo 20 caracteres" },
            nombre: { required: "Ingrese su nombre completo" },
            correo: { required: "Ingrese su correo", email: "El correo no tiene un formato válido" },
            contrasena: { required: "Ingrese una contraseña", minlength: "Mínimo 6 caracteres", maxlength: "Máximo 20 caracteres" },
            contrasena_confirmar: { required: "Repita la contraseña", equalTo: "Las contraseñas no coinciden" }
        },
        errorElement: "div",
        errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            if (element.closest(".form-group").length) {
                element.closest(".form-group").append(error);
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function (element) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        }
    });

});
