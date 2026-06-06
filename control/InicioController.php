<?php
// =====================================================================
// InicioController.php
// Controlador unico del modulo de inicio: login, registro y
// recuperacion de acceso. Cada formulario se identifica por el
// name de su boton de submit (btnLogin, btnRegistrar, btnRecuperar).
//
// Regla MVC: la vista nunca habla con el modelo, todo pasa por aqui.
// La conexion con MySQL se agrega en el Avance 2.
// =====================================================================

// ---- iniciar sesion ----
if (isset($_POST["btnLogin"])) {

    $cedula     = $_POST['cedula'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    // TODO (Avance 2): validar credenciales contra MySQL y crear la sesion
    echo "Datos recibidos: " . htmlspecialchars($cedula);
    echo "<br><br>Esta parte queda lista para el avance 2 cuando conectemos con MySQL.";
    echo "<br><a href='../view/vInicio/IniciarSesion.php'>Volver</a>";
}

// ---- registrar usuario ----
if (isset($_POST["btnRegistrar"])) {

    $cedula = $_POST['cedula'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';

    // TODO (Avance 2): insertar el usuario en MySQL (con procedimiento almacenado)
    echo "Datos recibidos: " . htmlspecialchars($nombre) . " - " . htmlspecialchars($cedula);
    echo "<br><br>Falta conectar con la base, eso lo terminamos en el avance 2.";
    echo "<br><a href='../view/vInicio/RegistrarUsuarios.php'>Volver</a>";
}

// ---- recuperar acceso ----
if (isset($_POST["btnRecuperar"])) {

    $correo = $_POST['correo'] ?? '';

    // TODO (Avance 2): generar token y enviar el correo de recuperacion
    echo "Solicitud recibida para: " . htmlspecialchars($correo);
    echo "<br><br>Falta el envio del correo, eso lo hacemos en el avance 2.";
    echo "<br><a href='../view/vInicio/RecuperarAcceso.php'>Volver</a>";
}
