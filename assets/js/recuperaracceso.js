// validaciones del formulario de recuperar acceso

$(function () {

    $("#form-recuperar").validate({
        rules: {
            correo: { required: true, email: true }
        },
        messages: {
            correo: { required: "Ingrese su correo electrónico", email: "El correo no tiene un formato válido" }
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
