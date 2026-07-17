<?php
// controlador del modulo de inicio: login, registro, logout
// y recuperacion de acceso
// cada formulario se identifica por el name de su boton de submit

include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/SeguridadController.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/UtilitarioController.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Model/UsuariosModel.php';

// cerrar sesion: es el proceso inverso al login, se destruyen las
// variables de sesion y se devuelve al usuario a iniciar sesion
if (isset($_POST["btnSalir"])) {

    CerrarSesion();

    header("Location: ../View/vInicio/IniciarSesion.php?msj=" . urlencode("Sesión cerrada correctamente.") . "&tipo=ok");
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

    // si entro con una contrasena temporal se le obliga a cambiarla
    $_SESSION['contrasena_temporal'] = ($usuario['contrasena_temporal'] == 1);

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

    if ($_SESSION['contrasena_temporal']) {
        header("Location: ../View/vPanel/CambiarContrasena.php?msj=" . urlencode("Ingresó con una contraseña temporal. Debe cambiarla para continuar.") . "&tipo=error");
        exit();
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

    // correo de bienvenida: se lee la plantilla html y se reemplazan los valores
    $plantilla = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/View/templates/Bienvenida.html');
    $plantilla = str_replace("{{NOMBRE}}", $nombre, $plantilla);
    $plantilla = str_replace("{{URL}}", URL_BASE . '/View/vInicio/IniciarSesion.php', $plantilla);

    EnviarCorreo($correo, $nombre, 'Bienvenido(a) a MediSalud CR', $plantilla);

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

        // paso 3: enviarla por correo con la plantilla html
        if ($actualizacion) {
            $plantilla = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/View/templates/Recuperacion.html');
            $plantilla = str_replace("{{TEMPORAL}}", $temporal, $plantilla);
            $plantilla = str_replace("{{NOMBRE}}", $datos['nombre'], $plantilla);

            EnviarCorreo($datos['correo'], $datos['nombre'], 'Recuperación de acceso - MediSalud CR', $plantilla);
        }
    }

    // el mensaje es el mismo exista o no el correo, para no revelar cuáles están registrados
    header("Location: ../View/vInicio/IniciarSesion.php?msj=" . urlencode("Si el correo está registrado, recibirá su contraseña temporal.") . "&tipo=ok");
    exit();
}

// si se llega aqui sin ningun formulario se vuelve al inicio
header("Location: ../View/vInicio/Principal.php");
exit();
