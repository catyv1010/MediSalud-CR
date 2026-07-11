// validaciones del formulario de especialidades

$(function () {

    $("#form-especialidad").validate({
        rules: {
            nombre: { required: true, maxlength: 100 }
        },
        messages: {
            nombre: { required: "Ingrese el nombre de la especialidad", maxlength: "Máximo 100 caracteres" }
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
