<?php
// controlador de los catalogos del administrador:
// especialidades, medicos, horarios y usuarios

include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/SeguridadController.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Model/MedicosModel.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Model/UsuariosModel.php';

// crear especialidad
if (isset($_POST["btnCrearEspecialidad"])) {

    ValidarSesion(array('administrador'));

    $nombre      = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $icono       = trim($_POST['icono'] ?? '');
    $color       = trim($_POST['color'] ?? '');

    if ($nombre == '') {
        header("Location: ../View/vAdmin/Especialidades.php?msj=" . urlencode("El nombre de la especialidad es obligatorio.") . "&tipo=error");
        exit();
    }

    $icono = IconoValido($icono);
    $color = ColorValido($color);

    if (CrearEspecialidadModel($nombre, $descripcion, $icono, $color)) {
        header("Location: ../View/vAdmin/Especialidades.php?msj=" . urlencode("Especialidad creada.") . "&tipo=ok");
        exit();
    }

    header("Location: ../View/vAdmin/Especialidades.php?msj=" . urlencode("No se pudo crear. Revise que el nombre no exista ya.") . "&tipo=error");
    exit();
}

// actualizar especialidad
if (isset($_POST["btnActualizarEspecialidad"])) {

    ValidarSesion(array('administrador'));

    $id          = intval($_POST['id'] ?? 0);
    $nombre      = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $icono       = trim($_POST['icono'] ?? '');
    $color       = trim($_POST['color'] ?? '');

    if ($id <= 0 || $nombre == '') {
        header("Location: ../View/vAdmin/Especialidades.php?msj=" . urlencode("Debe indicar la especialidad y su nombre.") . "&tipo=error");
        exit();
    }

    $icono = IconoValido($icono);
    $color = ColorValido($color);

    if (ActualizarEspecialidadModel($id, $nombre, $descripcion, $icono, $color)) {
        header("Location: ../View/vAdmin/Especialidades.php?msj=" . urlencode("Especialidad actualizada.") . "&tipo=ok");
        exit();
    }

    header("Location: ../View/vAdmin/Especialidades.php?msj=" . urlencode("No se pudo actualizar la especialidad.") . "&tipo=error");
    exit();
}

// eliminar especialidad (la base la protege si tiene medicos)
if (isset($_POST["btnEliminarEspecialidad"])) {

    ValidarSesion(array('administrador'));

    $id = intval($_POST['id'] ?? 0);

    if (EliminarEspecialidadModel($id)) {
        header("Location: ../View/vAdmin/Especialidades.php?msj=" . urlencode("Especialidad eliminada.") . "&tipo=ok");
        exit();
    }

    header("Location: ../View/vAdmin/Especialidades.php?msj=" . urlencode("No se pudo eliminar: la especialidad tiene médicos asociados.") . "&tipo=error");
    exit();
}

// crear medico (usuario + perfil)
if (isset($_POST["btnCrearMedico"])) {

    ValidarSesion(array('administrador'));

    $cedula         = trim($_POST['cedula'] ?? '');
    $nombre         = trim($_POST['nombre'] ?? '');
    $correo         = trim($_POST['correo'] ?? '');
    $telefono       = trim($_POST['telefono'] ?? '');
    $especialidadId = intval($_POST['especialidad'] ?? 0);
    $colegiado      = trim($_POST['colegiado'] ?? '');
    $contrasena     = $_POST['contrasena'] ?? '';

    if ($cedula == '' || $nombre == '' || $correo == '' || $colegiado == '' || $especialidadId <= 0) {
        header("Location: ../View/vAdmin/Medicos.php?msj=" . urlencode("Debe completar todos los campos del médico.") . "&tipo=error");
        exit();
    }
    if (strlen($contrasena) < 6 || strlen($contrasena) > 20) {
        header("Location: ../View/vAdmin/Medicos.php?msj=" . urlencode("La contraseña debe tener entre 6 y 20 caracteres.") . "&tipo=error");
        exit();
    }

    if (CrearMedicoModel($cedula, $correo, $contrasena, $nombre, $telefono, $especialidadId, $colegiado)) {
        header("Location: ../View/vAdmin/Medicos.php?msj=" . urlencode("Médico registrado.") . "&tipo=ok");
        exit();
    }

    header("Location: ../View/vAdmin/Medicos.php?msj=" . urlencode("No se pudo registrar. Revise que la cédula, el correo y el colegiado no existan ya.") . "&tipo=error");
    exit();
}

// actualizar medico
if (isset($_POST["btnActualizarMedico"])) {

    ValidarSesion(array('administrador'));

    $medicoId       = intval($_POST['medico_id'] ?? 0);
    $nombre         = trim($_POST['nombre'] ?? '');
    $telefono       = trim($_POST['telefono'] ?? '');
    $especialidadId = intval($_POST['especialidad'] ?? 0);
    $colegiado      = trim($_POST['colegiado'] ?? '');

    if ($medicoId <= 0 || $nombre == '' || $colegiado == '' || $especialidadId <= 0) {
        header("Location: ../View/vAdmin/EditarMedico.php?id=$medicoId&msj=" . urlencode("Debe completar todos los campos.") . "&tipo=error");
        exit();
    }

    if (ActualizarMedicoModel($medicoId, $nombre, $telefono, $especialidadId, $colegiado)) {
        header("Location: ../View/vAdmin/Medicos.php?msj=" . urlencode("Médico actualizado.") . "&tipo=ok");
        exit();
    }

    header("Location: ../View/vAdmin/EditarMedico.php?id=$medicoId&msj=" . urlencode("No se pudo actualizar el médico.") . "&tipo=error");
    exit();
}

// agregar franja de atencion a un medico
if (isset($_POST["btnAgregarHorario"])) {

    ValidarSesion(array('administrador'));

    $medicoId   = intval($_POST['medico_id'] ?? 0);
    $diaSemana  = $_POST['dia_semana'] ?? '';
    $horaInicio = $_POST['hora_inicio'] ?? '';
    $horaFin    = $_POST['hora_fin'] ?? '';

    // los dias validos salen del catalogo de la base, no de una lista escrita aqui
    $dias = array();
    foreach (DiasControl() as $dia) {
        $dias[] = $dia['nombre'];
    }

    if ($medicoId <= 0 || !in_array($diaSemana, $dias) || $horaInicio == '' || $horaFin == '') {
        header("Location: ../View/vAdmin/HorariosMedico.php?medico=$medicoId&msj=" . urlencode("Debe indicar el día y las horas de la franja.") . "&tipo=error");
        exit();
    }
    if ($horaInicio >= $horaFin) {
        header("Location: ../View/vAdmin/HorariosMedico.php?medico=$medicoId&msj=" . urlencode("La hora de inicio debe ser menor a la hora final.") . "&tipo=error");
        exit();
    }

    if (AgregarHorarioModel($medicoId, $diaSemana, $horaInicio . ':00', $horaFin . ':00')) {
        header("Location: ../View/vAdmin/HorariosMedico.php?medico=$medicoId&msj=" . urlencode("Franja agregada.") . "&tipo=ok");
        exit();
    }

    header("Location: ../View/vAdmin/HorariosMedico.php?medico=$medicoId&msj=" . urlencode("No se pudo agregar la franja.") . "&tipo=error");
    exit();
}

// eliminar franja de atencion
if (isset($_POST["btnEliminarHorario"])) {

    ValidarSesion(array('administrador'));

    $medicoId  = intval($_POST['medico_id'] ?? 0);
    $horarioId = intval($_POST['horario_id'] ?? 0);

    if (EliminarHorarioModel($horarioId)) {
        header("Location: ../View/vAdmin/HorariosMedico.php?medico=$medicoId&msj=" . urlencode("Franja eliminada.") . "&tipo=ok");
        exit();
    }

    header("Location: ../View/vAdmin/HorariosMedico.php?medico=$medicoId&msj=" . urlencode("No se pudo eliminar la franja.") . "&tipo=error");
    exit();
}

// activar o desactivar un usuario
if (isset($_POST["btnEstadoUsuario"])) {

    ValidarSesion(array('administrador'));

    $usuarioId = intval($_POST['usuario_id'] ?? 0);
    $activo    = intval($_POST['activo'] ?? 0);

    // se vuelve a la pantalla desde donde se presiono el boton
    // (el mismo boton esta en Usuarios y en Medicos)
    $rutaVolver = ($_POST['origen'] ?? '') == 'medicos'
        ? '../View/vAdmin/Medicos.php'
        : '../View/vAdmin/Usuarios.php';

    // el administrador no se puede desactivar a si mismo
    if ($usuarioId == $_SESSION['usuario_id']) {
        header("Location: $rutaVolver?msj=" . urlencode("No puede desactivar su propio usuario.") . "&tipo=error");
        exit();
    }

    if (CambiarEstadoUsuarioModel($usuarioId, $activo)) {
        header("Location: $rutaVolver?msj=" . urlencode("Estado del usuario actualizado.") . "&tipo=ok");
        exit();
    }

    header("Location: $rutaVolver?msj=" . urlencode("No se pudo actualizar el usuario.") . "&tipo=error");
    exit();
}

// funciones que usan las vistas del administrador

function EspecialidadesAdminControl()
{
    return ListarEspecialidadesModel();
}

function MedicosAdminControl()
{
    return ListarMedicosAdminModel();
}

// funciones que usan las vistas publicas (antes de iniciar sesion)

function EspecialidadesPublicoControl()
{
    return ListarEspecialidadesModel();
}

function MedicosPublicoControl()
{
    return ListarMedicosPublicoModel();
}

function MedicoPublicoControl($medicoId)
{
    return ObtenerMedicoPublicoModel($medicoId);
}

// busca un medico dentro de la lista (para la pantalla de editar)
function MedicoAdminControl($medicoId)
{
    foreach (ListarMedicosAdminModel() as $medico) {
        if ($medico['id'] == $medicoId) {
            return $medico;
        }
    }
    return null;
}

function FranjasAdminControl($medicoId)
{
    return FranjasMedicoModel($medicoId);
}

function UsuariosAdminControl()
{
    return ListarUsuariosModel();
}

// catalogos de la base que llenan los selects de las vistas

function GenerosControl()
{
    return ListarGenerosModel();
}

function DiasControl()
{
    return ListarDiasModel();
}

// iconos disponibles para las tarjetas de especialidades
// son las clases de la plantilla (themify icons), por eso viven en el controlador
function IconosControl()
{
    return array(
        'ti-heart'    => 'Corazón',
        'ti-shine'    => 'Brillo',
        'ti-user'     => 'Persona',
        'ti-eye'      => 'Ojo',
        'ti-pulse'    => 'Pulso',
        'ti-apple'    => 'Manzana',
        'ti-plus'     => 'Cruz médica',
        'ti-clipboard'=> 'Expediente'
    );
}

// el icono debe ser uno de la lista, si no se manda el que trae por defecto
function IconoValido($icono)
{
    return array_key_exists($icono, IconosControl()) ? $icono : 'ti-heart';
}

// el color debe venir en formato #RRGGBB, si no se usa el azul del sistema
function ColorValido($color)
{
    return preg_match('/^#[0-9a-fA-F]{6}$/', $color) ? $color : '#244cb6';
}