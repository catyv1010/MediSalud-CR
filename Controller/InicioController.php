<?php
// controlador del modulo de inicio: login, registro, logout,
// recuperacion y cambio de contrasena
// cada formulario se identifica por el name de su boton de submit

include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/SeguridadController.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/UtilitarioController.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Model/UsuariosModel.php';

// cerrar sesion (llega por GET: InicioController.php?accion=logout)
if (isset($_GET['accion']) && $_GET['accion'] == 'logout') {

    session_unset();
    session_destroy();

    header("Location: ../View/vInicio/Principal.php?msj=" . urlencode("Sesión cerrada correctamente.") . "&tipo=ok");
    exit();
}

// iniciar sesion
if (isset($_POST["btnLogin"])) {

    $identificacion = trim($_POST['cedula'] ?? '');
    $contrasena     = $_POST['contrasena'] ?? '';

    if ($identificacion == '' || $contrasena == '') {
        header("Location: ../View/vInicio/IniciarSesion.php?msj=" . urlencode("Debe completar todos los campos.") . "&tipo=error");
        exit();
    }

    // el SP compara las credenciales y devuelve el usuario si existe
    $usuario = IniciarSesionModel($identificacion, $contrasena);

    if ($usuario == null) {
        header("Location: ../View/vInicio/IniciarSesion.php?msj=" . urlencode("Credenciales incorrectas o usuario inactivo.") . "&tipo=error");
        exit();
    }

    // se guarda lo basico en la sesion
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['nombre']     = $usuario['nombre'];
    $_SESSION['correo']     = $usuario['correo'];
    $_SESSION['rol']        = $usuario['rol'];

    // datos extra segun el rol, se ocupan en el modulo de citas
    if ($usuario['rol'] == 'paciente') {
        $perfil = ObtenerPacienteModel($usuario['id']);
        $_SESSION['paciente_id'] = ($perfil != null) ? $perfil['paciente_id'] : null;
    }
    if ($usuario['rol'] == 'medico') {
        $perfil = ObtenerMedicoModel($usuario['id']);
        $_SESSION['medico_id']    = ($perfil != null) ? $perfil['medico_id'] : null;
        $_SESSION['especialidad'] = ($perfil != null) ? $perfil['especialidad'] : '';
    }

    header("Location: " . RutaPanel($usuario['rol']) . "?msj=" . urlencode("Bienvenido(a), " . $usuario['nombre'] . ".") . "&tipo=ok");
    exit();
}

// registrar paciente
if (isset($_POST["btnRegistrar"])) {

    $cedula          = trim($_POST['cedula'] ?? '');
    $nombre          = trim($_POST['nombre'] ?? '');
    $correo          = trim($_POST['correo'] ?? '');
    $telefono        = trim($_POST['telefono'] ?? '');
    $fechaNacimiento = $_POST['fecha_nacimiento'] ?? '';
    $genero          = $_POST['genero'] ?? '';
    $direccion       = trim($_POST['direccion'] ?? '');
    $contrasena      = $_POST['contrasena'] ?? '';
    $confirmar       = $_POST['contrasena_confirmar'] ?? '';

    // se valida tambien en el servidor porque lo del navegador se puede saltar
    if ($cedula == '' || $nombre == '' || $correo == '' || $contrasena == '') {
        header("Location: ../View/vInicio/RegistrarUsuarios.php?msj=" . urlencode("Debe completar los campos obligatorios.") . "&tipo=error");
        exit();
    }
    if (strlen($contrasena) < 6 || strlen($contrasena) > 20) {
        header("Location: ../View/vInicio/RegistrarUsuarios.php?msj=" . urlencode("La contraseña debe tener entre 6 y 20 caracteres.") . "&tipo=error");
        exit();
    }
    if ($contrasena != $confirmar) {
        header("Location: ../View/vInicio/RegistrarUsuarios.php?msj=" . urlencode("Las contraseñas no coinciden.") . "&tipo=error");
        exit();
    }

    $datos = RegistrarPacienteModel($cedula, $correo, $contrasena, $nombre, $telefono, $fechaNacimiento, $genero, $direccion);

    if (!$datos) {
        header("Location: ../View/vInicio/RegistrarUsuarios.php?msj=" . urlencode("No se pudo registrar. Revise que la cédula y el correo no estén ya registrados.") . "&tipo=error");
        exit();
    }

    // correo de bienvenida
    $cuerpo = PlantillaCorreo(
        'Bienvenido(a) a MediSalud CR',
        '<p>Hola <strong>' . htmlspecialchars($nombre) . '</strong>:</p>
         <p>Su cuenta fue creada correctamente. Ya puede iniciar sesión y agendar sus citas en línea.</p>
         <p><a href="' . URL_BASE . '/View/vInicio/IniciarSesion.php">Iniciar sesión</a></p>'
    );
    EnviarCorreo($correo, $nombre, 'Bienvenido(a) a MediSalud CR', $cuerpo);

    header("Location: ../View/vInicio/IniciarSesion.php?msj=" . urlencode("Cuenta creada con éxito. Ya puede iniciar sesión.") . "&tipo=ok");
    exit();
}

// recuperar acceso: se genera una contrasena temporal y se envia por correo
// (los 3 pasos de la clase: validar el correo, generar y actualizar, enviar)
if (isset($_POST["btnRecuperar"])) {

    $correo = trim($_POST['correo'] ?? '');

    if ($correo == '') {
        header("Location: ../View/vInicio/RecuperarAcceso.php?msj=" . urlencode("Ingrese su correo electrónico.") . "&tipo=error");
        exit();
    }

    // paso 1: el correo debe existir y estar activo
    $datos = ValidarCorreoModel($correo);

    if ($datos != null) {

        // paso 2: generar la contrasena temporal y actualizarla en la base
        $temporal = GenerarContrasena();
        $actualizacion = ActualizarContrasenaModel(intval($datos['id']), $temporal);

        // paso 3: enviarla por correo
        if ($actualizacion) {
            $cuerpo = PlantillaCorreo(
                'Recuperación de acceso',
                '<p>Hola <strong>' . htmlspecialchars($datos['nombre']) . '</strong>:</p>
                 <p>Su nueva contraseña temporal es:</p>
                 <p style="font-size:22px; font-weight:bold; letter-spacing:2px;">' . $temporal . '</p>
                 <p>Ingrese al sistema con esta contraseña y cámbiela por una de su preferencia
                 en la opción Contraseña del menú.</p>'
            );
            EnviarCorreo($datos['correo'], $datos['nombre'], 'Recuperación de acceso - MediSalud CR', $cuerpo);
        }
    }

    // el mensaje es el mismo exista o no el correo, para no revelar cuáles están registrados
    header("Location: ../View/vInicio/IniciarSesion.php?msj=" . urlencode("Si el correo está registrado, recibirá su contraseña temporal.") . "&tipo=ok");
    exit();
}

// cambio de contrasena con la sesion iniciada
if (isset($_POST["btnCambiarContrasena"])) {

    ValidarSesion();

    $actual    = $_POST['contrasena_actual'] ?? '';
    $nueva     = $_POST['contrasena_nueva'] ?? '';
    $confirmar = $_POST['contrasena_confirmar'] ?? '';

    if (strlen($nueva) < 6 || strlen($nueva) > 20) {
        header("Location: ../View/vPanel/CambiarContrasena.php?msj=" . urlencode("La contraseña nueva debe tener entre 6 y 20 caracteres.") . "&tipo=error");
        exit();
    }
    if ($nueva != $confirmar) {
        header("Location: ../View/vPanel/CambiarContrasena.php?msj=" . urlencode("La confirmación no coincide con la contraseña nueva.") . "&tipo=error");
        exit();
    }

    // el SP valida la contrasena actual antes de cambiarla
    $resultado = CambiarContrasenaModel(intval($_SESSION['usuario_id']), $actual, $nueva);

    if ($resultado == 'OK') {
        header("Location: ../View/vPanel/CambiarContrasena.php?msj=" . urlencode("Contraseña actualizada correctamente.") . "&tipo=ok");
        exit();
    }
    if ($resultado == 'ACTUAL_INCORRECTA') {
        header("Location: ../View/vPanel/CambiarContrasena.php?msj=" . urlencode("La contraseña actual es incorrecta.") . "&tipo=error");
        exit();
    }

    header("Location: ../View/vPanel/CambiarContrasena.php?msj=" . urlencode("No fue posible actualizar la contraseña.") . "&tipo=error");
    exit();
}

// si se llega aqui sin ningun formulario se vuelve al inicio
header("Location: ../View/vInicio/Principal.php");
exit();
