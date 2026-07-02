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
        }
    });

});
