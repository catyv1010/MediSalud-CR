// js del modulo de citas (jquery + ajax)
// los selects de medico y hora se llenan con llamados asincronos
// al controlador, que responde en formato JSON

$(function () {

    // pide confirmacion antes de cancelar una cita
    $(".form-cancelar").on("submit", function (e) {
        if (!window.confirm("¿Seguro que desea cancelar esta cita?")) {
            e.preventDefault();
        }
    });

    // no deja guardar el estado si no se eligio uno
    $(".form-estado").on("submit", function (e) {
        if ($(this).find("select[name='estado_id']").val() == "") {
            e.preventDefault();
            window.alert("Seleccione el estado nuevo de la cita.");
        }
    });

    // pide confirmacion antes de eliminar un registro
    $(".form-eliminar").on("submit", function (e) {
        if (!window.confirm("¿Seguro que desea eliminar este registro?")) {
            e.preventDefault();
        }
    });

    // lo que sigue es solo para la pagina de agendar
    if ($("#form-agendar").length == 0) {
        return;
    }

    // la fecha minima para agendar es hoy
    var hoy = new Date().toISOString().split("T")[0];
    $("#fecha").attr("min", hoy);

    // al elegir la especialidad se cargan sus medicos
    $("#especialidad").on("change", function () {

        var especialidadId = $(this).val();

        $("#medico").html('<option value="">Cargando...</option>');
        $("#hora").html('<option value="">Seleccione médico y fecha</option>');

        if (especialidadId == "") {
            $("#medico").html('<option value="">Seleccione una especialidad primero</option>');
            return;
        }

        $.ajax({
            type: "get",
            url: "../../Controller/CitasController.php",
            data: { accion: "medicos", especialidad: especialidadId },
            dataType: "json",
            success: function (medicos) {
                var opciones = '<option value="">Seleccione el médico</option>';
                $.each(medicos, function (i, medico) {
                    opciones += '<option value="' + medico.id + '">' + medico.nombre + '</option>';
                });
                if (medicos.length == 0) {
                    opciones = '<option value="">No hay médicos en esta especialidad</option>';
                }
                $("#medico").html(opciones);
            },
            error: function () {
                $("#medico").html('<option value="">Error al cargar los médicos</option>');
            }
        });
    });

    // cuando ya hay medico y fecha se consultan las horas libres
    function cargarHoras() {

        var medicoId = $("#medico").val();
        var fecha = $("#fecha").val();

        if (medicoId == "" || fecha == "" || medicoId == null) {
            $("#hora").html('<option value="">Seleccione médico y fecha</option>');
            return;
        }

        $("#hora").html('<option value="">Cargando...</option>');

        $.ajax({
            type: "get",
            url: "../../Controller/CitasController.php",
            data: { accion: "disponibilidad", medico: medicoId, fecha: fecha },
            dataType: "json",
            success: function (horas) {
                if (horas.length == 0) {
                    $("#hora").html('<option value="">Sin horas libres ese día, pruebe otra fecha</option>');
                    return;
                }
                var opciones = '<option value="">Seleccione la hora</option>';
                $.each(horas, function (i, hora) {
                    opciones += '<option value="' + hora + '">' + hora + '</option>';
                });
                $("#hora").html(opciones);
            },
            error: function () {
                $("#hora").html('<option value="">Error al consultar la disponibilidad</option>');
            }
        });
    }

    $("#medico").on("change", cargarHoras);
    $("#fecha").on("change", cargarHoras);

});
