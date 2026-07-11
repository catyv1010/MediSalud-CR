// validaciones del formulario de cambio de contrasena

$(function () {

    $("#form-cambiar").validate({
        rules: {
            contrasena_actual: { required: true },
            contrasena_nueva: { required: true, minlength: 6, maxlength: 20 },
            contrasena_confirmar: { required: true, equalTo: "#contrasena" }
        },
        messages: {
            contrasena_actual: { required: "Ingrese su contraseña actual" },
            contrasena_nueva: { required: "Ingrese la contraseña nueva", minlength: "Mínimo 6 caracteres", maxlength: "Máximo 20 caracteres" },
            contrasena_confirmar: { required: "Repita la contraseña nueva", equalTo: "La confirmación no coincide" }
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
