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
        }
    });

});
