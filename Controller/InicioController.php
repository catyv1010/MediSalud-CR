<?php
// controlador del modulo de inicio: login, registro, logout,
// recuperacion y cambio de contrasena
// cada formulario se identifica por el name de su boton de submit

include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/SeguridadController.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Model/UsuariosModel.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Model/CorreoModel.php';

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
    EnviarCorreoModel($correo, $nombre, 'Bienvenido(a) a MediSalud CR', $cuerpo);

    header("Location: ../View/vInicio/IniciarSesion.php?msj=" . urlencode("Cuenta creada con éxito. Ya puede iniciar sesión.") . "&tipo=ok");
    exit();
}

// recuperar acceso: se genera un token y se manda el enlace por correo
if (isset($_POST["btnRecuperar"])) {

    $correo = trim($_POST['correo'] ?? '');

    if ($correo == '') {
        header("Location: ../View/vInicio/RecuperarAcceso.php?msj=" . urlencode("Ingrese su correo electrónico.") . "&tipo=error");
        exit();
    }

    $usuario = ObtenerUsuarioPorCorreoModel($correo);

    if ($usuario != null) {

        // token aleatorio que vence en 30 minutos
        $token = md5(uniqid($usuario['id'], true));
        GuardarTokenModel($usuario['id'], $token, 30);

        $enlace = URL_BASE . '/View/vInicio/RestablecerContrasena.php?token=' . $token;
        $cuerpo = PlantillaCorreo(
            'Recuperación de contraseña',
            '<p>Hola <strong>' . htmlspecialchars($usuario['nombre']) . '</strong>:</p>
             <p>Recibimos una solicitud para restablecer su contraseña.
             Haga clic en el siguiente enlace (vence en 30 minutos):</p>
             <p><a href="' . $enlace . '">' . $enlace . '</a></p>
             <p>Si usted no lo solicitó, ignore este mensaje.</p>'
        );
        EnviarCorreoModel($usuario['correo'], $usuario['nombre'], 'Recuperación de contraseña - MediSalud CR', $cuerpo);
    }

    // el mensaje es el mismo exista o no el correo, para no revelar cuáles están registrados
    header("Location: ../View/vInicio/RecuperarAcceso.php?msj=" . urlencode("Si el correo está registrado, recibirá un enlace de recuperación.") . "&tipo=ok");
    exit();
}

// restablecer contrasena desde el enlace del correo
if (isset($_POST["btnRestablecer"])) {

    $token      = $_POST['token'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';
    $confirmar  = $_POST['contrasena_confirmar'] ?? '';

    if (strlen($contrasena) < 6 || strlen($contrasena) > 20) {
        header("Location: ../View/vInicio/RestablecerContrasena.php?token=" . urlencode($token) . "&msj=" . urlencode("La contraseña debe tener entre 6 y 20 caracteres.") . "&tipo=error");
        exit();
    }
    if ($contrasena != $confirmar) {
        header("Location: ../View/vInicio/RestablecerContrasena.php?token=" . urlencode($token) . "&msj=" . urlencode("Las contraseñas no coinciden.") . "&tipo=error");
        exit();
    }

    if (RestablecerContrasenaModel($token, $contrasena)) {
        header("Location: ../View/vInicio/IniciarSesion.php?msj=" . urlencode("Contraseña actualizada. Ya puede iniciar sesión.") . "&tipo=ok");
        exit();
    }

    header("Location: ../View/vInicio/RecuperarAcceso.php?msj=" . urlencode("El enlace ya no es válido. Solicite uno nuevo.") . "&tipo=error");
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
