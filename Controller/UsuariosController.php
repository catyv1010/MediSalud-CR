<?php
// controlador del perfil del usuario con sesion iniciada:
// consultar y actualizar los datos personales y cambiar la contrasena

include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/SeguridadController.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/UtilitarioController.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Model/UsuariosModel.php';

// actualizar los datos del perfil
if (isset($_POST["btnCambiarPerfil"])) {

    ValidarSesion();

    $cedula   = trim($_POST['cedula'] ?? '');
    $nombre   = trim($_POST['nombre'] ?? '');
    $correo   = trim($_POST['correo'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');

    if ($cedula == '' || $nombre == '' || $correo == '') {
        header("Location: ../View/vPanel/MiPerfil.php?msj=" . urlencode("Debe completar los campos obligatorios.") . "&tipo=error");
        exit();
    }

    // el id nunca viene del formulario, siempre se toma de la sesion
    // (cada quien solo puede modificar su propia informacion)
    $resultado = ActualizarPerfilModel(intval($_SESSION['usuario_id']), $cedula, $nombre, $correo, $telefono);

    if ($resultado) {

        // se refrescan los valores que estaban guardados en la sesion
        $_SESSION['nombre'] = $nombre;
        $_SESSION['correo'] = $correo;

        header("Location: ../View/vPanel/MiPerfil.php?msj=" . urlencode("Su información personal se actualizó correctamente.") . "&tipo=ok");
        exit();
    }

    header("Location: ../View/vPanel/MiPerfil.php?msj=" . urlencode("No se pudo actualizar. Revise que la cédula y el correo no estén registrados por otra persona.") . "&tipo=error");
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

        // correo de confirmacion con la plantilla html
        $plantilla = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/View/templates/CambioContrasena.html');
        $plantilla = str_replace("{{NOMBRE}}", $_SESSION['nombre'], $plantilla);
        $plantilla = str_replace("{{FECHA}}", date('d/m/Y h:i A'), $plantilla);

        EnviarCorreo($_SESSION['correo'], $_SESSION['nombre'], 'Cambio de contraseña - MediSalud CR', $plantilla);

        // por seguridad se cierra la sesion para que entre con la contrasena nueva
        CerrarSesion();

        header("Location: ../View/vInicio/IniciarSesion.php?msj=" . urlencode("Contraseña actualizada. Inicie sesión con su contraseña nueva.") . "&tipo=ok");
        exit();
    }
    if ($resultado == 'ACTUAL_INCORRECTA') {
        header("Location: ../View/vPanel/CambiarContrasena.php?msj=" . urlencode("La contraseña actual es incorrecta.") . "&tipo=error");
        exit();
    }

    header("Location: ../View/vPanel/CambiarContrasena.php?msj=" . urlencode("No fue posible actualizar la contraseña.") . "&tipo=error");
    exit();
}

// datos actuales del usuario, la vista los usa para precargar el formulario
function PerfilControl()
{
    return ConsultarUsuarioModel(intval($_SESSION['usuario_id']));
}
