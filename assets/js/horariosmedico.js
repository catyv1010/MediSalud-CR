// validaciones del formulario de franjas de atencion

$(function () {

    $("#form-horario").validate({
        rules: {
            dia_semana: { required: true },
            hora_inicio: { required: true },
            hora_fin: { required: true }
        },
        messages: {
            dia_semana: { required: "Seleccione el día" },
            hora_inicio: { required: "Indique la hora de inicio" },
            hora_fin: { required: "Indique la hora final" }
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
