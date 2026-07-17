// validaciones del formulario de iniciar sesion

$(function () {

    $("#form-login").validate({
        rules: {
            cedula: { required: true },
            contrasena: { required: true }
        },
        messages: {
            cedula: { required: "Ingrese su cédula" },
            contrasena: { required: "Ingrese su contraseña" }
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
