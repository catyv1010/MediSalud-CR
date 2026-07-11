// validaciones del formulario de agendar cita
// (los selects se llenan por ajax en citas.js)

$(function () {

    $("#form-agendar").validate({
        rules: {
            especialidad: { required: true },
            medico: { required: true },
            fecha: { required: true },
            hora: { required: true }
        },
        messages: {
            especialidad: { required: "Seleccione la especialidad" },
            medico: { required: "Seleccione el médico" },
            fecha: { required: "Seleccione la fecha" },
            hora: { required: "Seleccione la hora" }
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
