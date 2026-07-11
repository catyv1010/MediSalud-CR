<?php
// controlador del modulo de citas
// atiende los formularios, los llamados ajax (responden JSON)
// y las funciones que las vistas usan para pintar sus tablas

include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/SeguridadController.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/UtilitarioController.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Model/CitasModel.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Model/MedicosModel.php';

// llamado ajax: medicos de una especialidad
// CitasController.php?accion=medicos&especialidad=N
if (isset($_GET['accion']) && $_GET['accion'] == 'medicos') {

    ValidarSesion(array('paciente'));

    $especialidadId = intval($_GET['especialidad'] ?? 0);

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(MedicosPorEspecialidadModel($especialidadId));
    exit();
}

// llamado ajax: horas libres de un medico en una fecha
// CitasController.php?accion=disponibilidad&medico=N&fecha=AAAA-MM-DD
if (isset($_GET['accion']) && $_GET['accion'] == 'disponibilidad') {

    ValidarSesion(array('paciente'));

    $medicoId = intval($_GET['medico'] ?? 0);
    $fecha    = $_GET['fecha'] ?? '';

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(HorasDisponiblesControl($medicoId, $fecha));
    exit();
}

// arma las horas libres: toma las franjas del medico para ese dia,
// las parte en bloques de 30 minutos y quita los que ya estan ocupados
function HorasDisponiblesControl($medicoId, $fecha)
{
    $marca = strtotime($fecha);
    if ($marca === false) {
        return array();
    }

    // dia de la semana con los mismos nombres de la tabla
    $dias = array('Monday'=>'Lunes','Tuesday'=>'Martes','Wednesday'=>'Miercoles',
                  'Thursday'=>'Jueves','Friday'=>'Viernes','Saturday'=>'Sabado','Sunday'=>'Domingo');
    $diaSemana = $dias[date('l', $marca)];

    // horas ya reservadas ese dia
    $ocupadas = array();
    foreach (HorasOcupadasModel($medicoId, $fecha) as $fila) {
        $ocupadas[] = substr($fila['hora'], 0, 5);
    }

    // bloques de 30 minutos dentro de las franjas del dia
    $libres = array();
    foreach (FranjasMedicoModel($medicoId) as $franja) {
        if ($franja['dia_semana'] != $diaSemana) {
            continue;
        }
        $hora = strtotime($fecha . ' ' . $franja['hora_inicio']);
        $fin  = strtotime($fecha . ' ' . $franja['hora_fin']);
        while ($hora < $fin) {
            $etiqueta = date('H:i', $hora);
            if (!in_array($etiqueta, $ocupadas) && $hora > time()) {
                $libres[] = $etiqueta;
            }
            $hora = $hora + (30 * 60);
        }
    }

    return $libres;
}

// agendar cita (paciente)
if (isset($_POST["btnAgendar"])) {

    ValidarSesion(array('paciente'));

    $medicoId = intval($_POST['medico'] ?? 0);
    $fecha    = $_POST['fecha'] ?? '';
    $hora     = $_POST['hora'] ?? '';
    $motivo   = trim($_POST['motivo'] ?? '');

    if ($medicoId <= 0 || $fecha == '' || $hora == '') {
        header("Location: ../View/vCitas/AgendarCita.php?msj=" . urlencode("Debe seleccionar especialidad, médico, fecha y hora.") . "&tipo=error");
        exit();
    }
    if (strtotime($fecha) === false || strtotime($fecha) < strtotime(date('Y-m-d'))) {
        header("Location: ../View/vCitas/AgendarCita.php?msj=" . urlencode("La fecha de la cita debe ser hoy o una fecha futura.") . "&tipo=error");
        exit();
    }
    // la hora debe estar realmente libre, por si manipulan el formulario
    if (!in_array($hora, HorasDisponiblesControl($medicoId, $fecha))) {
        header("Location: ../View/vCitas/AgendarCita.php?msj=" . urlencode("La hora seleccionada ya no está disponible. Elija otra.") . "&tipo=error");
        exit();
    }

    $citaId = AgendarCitaModel(intval($_SESSION['paciente_id']), $medicoId, $fecha, $hora . ':00', $motivo);

    if (!$citaId) {
        header("Location: ../View/vCitas/AgendarCita.php?msj=" . urlencode("No se pudo agendar la cita, el horario ya está reservado.") . "&tipo=error");
        exit();
    }

    // notificacion por correo con el comprobante
    // se lee la plantilla html y se reemplazan los valores de la cita
    $cita = DatosCitaModel(intval($citaId));
    if ($cita != null) {
        $plantilla = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/View/templates/CitaConfirmada.html');
        $plantilla = str_replace("{{NOMBRE}}", $cita['paciente'], $plantilla);
        $plantilla = str_replace("{{MEDICO}}", $cita['medico'], $plantilla);
        $plantilla = str_replace("{{ESPECIALIDAD}}", $cita['especialidad'], $plantilla);
        $plantilla = str_replace("{{FECHA}}", $cita['fecha'], $plantilla);
        $plantilla = str_replace("{{HORA}}", substr($cita['hora'], 0, 5), $plantilla);

        EnviarCorreo($cita['correo_paciente'], $cita['paciente'], 'Cita confirmada - MediSalud CR', $plantilla);
    }

    header("Location: ../View/vCitas/MisCitas.php?msj=" . urlencode("Cita agendada con éxito. Se envió un comprobante a su correo.") . "&tipo=ok");
    exit();
}

// cancelar cita (el paciente dueno de la cita)
if (isset($_POST["btnCancelarCita"])) {

    ValidarSesion(array('paciente'));

    $citaId = intval($_POST['cita_id'] ?? 0);

    // la cita debe ser del paciente que tiene la sesion
    $cita = DatosCitaModel($citaId);
    if ($cita == null || $cita['paciente_usuario_id'] != $_SESSION['usuario_id']) {
        header("Location: ../View/vCitas/MisCitas.php?msj=" . urlencode("La cita indicada no existe o no le pertenece.") . "&tipo=error");
        exit();
    }

    if (!CancelarCitaModel($citaId)) {
        header("Location: ../View/vCitas/MisCitas.php?msj=" . urlencode("No se puede cancelar con menos de 24 horas de anticipación.") . "&tipo=error");
        exit();
    }

    header("Location: ../View/vCitas/MisCitas.php?msj=" . urlencode("La cita fue cancelada.") . "&tipo=ok");
    exit();
}

// cambiar el estado de una cita (medico o administrador)
if (isset($_POST["btnActualizarEstado"])) {

    ValidarSesion(array('medico', 'administrador'));

    $citaId   = intval($_POST['cita_id'] ?? 0);
    $estadoId = intval($_POST['estado_id'] ?? 0);

    $rutaVolver = ($_SESSION['rol'] == 'medico')
        ? '../View/vCitas/CitasMedico.php'
        : '../View/vCitas/GestionCitas.php';

    // estados permitidos: 2=Atendida, 3=Cancelada, 4=No asistio
    if (!in_array($estadoId, array(2, 3, 4))) {
        header("Location: $rutaVolver?msj=" . urlencode("El estado indicado no es válido.") . "&tipo=error");
        exit();
    }

    $cita = DatosCitaModel($citaId);
    if ($cita == null) {
        header("Location: $rutaVolver?msj=" . urlencode("La cita indicada no existe.") . "&tipo=error");
        exit();
    }

    // un medico solo puede tocar sus propias citas
    if ($_SESSION['rol'] == 'medico' && $cita['medico_usuario_id'] != $_SESSION['usuario_id']) {
        header("Location: $rutaVolver?msj=" . urlencode("Solo puede actualizar sus propias citas.") . "&tipo=error");
        exit();
    }

    if (ActualizarEstadoCitaModel($citaId, $estadoId)) {
        header("Location: $rutaVolver?msj=" . urlencode("El estado de la cita fue actualizado.") . "&tipo=ok");
        exit();
    }

    header("Location: $rutaVolver?msj=" . urlencode("No fue posible actualizar la cita.") . "&tipo=error");
    exit();
}

// funciones que usan las vistas para pintar sus datos
// (la vista incluye este controlador y llama a la que necesite)

function EspecialidadesControl()
{
    return ListarEspecialidadesModel();
}

function CitasPacienteControl()
{
    return ListarCitasPacienteModel(intval($_SESSION['paciente_id']));
}

function CitasMedicoControl()
{
    return ListarCitasMedicoModel(intval($_SESSION['medico_id']));
}

function AgendaHoyMedicoControl()
{
    return AgendaDiariaMedicoModel(intval($_SESSION['medico_id']), date('Y-m-d'));
}

function CitasAdminControl()
{
    return ListarCitasAdminModel();
}

function ContadoresControl()
{
    return ContadoresPanelModel();
}

// citas de un mes agrupadas por dia (para el calendario)
function CitasDelMesControl($mes, $anio)
{
    $porDia = array();
    foreach (CitasDelMesModel($mes, $anio) as $cita) {
        $dia = intval(substr($cita['fecha'], 8, 2));
        $porDia[$dia][] = $cita;
    }
    return $porDia;
}

function ReporteMensualControl($mes, $anio)
{
    return ReporteMensualModel($mes, $anio);
}
                                                                                                                                 