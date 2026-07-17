// validaciones del formulario de mi perfil

$(function () {

    $("#form-perfil").validate({
        rules: {
            cedula: { required: true, maxlength: 20 },
            nombre: { required: true, maxlength: 150 },
            correo: { required: true, email: true },
            telefono: { maxlength: 20 }
        },
        messages: {
            cedula: { required: "Ingrese su cédula", maxlength: "Máximo 20 caracteres" },
            nombre: { required: "Ingrese su nombre completo", maxlength: "Máximo 150 caracteres" },
            correo: { required: "Ingrese su correo", email: "El correo no tiene un formato válido" },
            telefono: { maxlength: "Máximo 20 caracteres" }
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
