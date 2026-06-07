<?php
// controlador del modulo de inicio: login, registro y recuperacion
// cada formulario se identifica por el name de su boton de submit
// la conexion con la base la armamos en el avance 2

// iniciar sesion
if (isset($_POST["btnLogin"])) {

    $cedula     = $_POST['cedula'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    echo "Datos recibidos: " . htmlspecialchars($cedula);
    echo "<br><br>Esta parte queda lista para el avance 2 cuando conectemos con MySQL.";
    echo "<br><a href='../view/vInicio/IniciarSesion.php'>Volver</a>";
}

// registrar usuario
if (isset($_POST["btnRegistrar"])) {

    $cedula = $_POST['cedula'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';

    echo "Datos recibidos: " . htmlspecialchars($nombre) . " - " . htmlspecialchars($cedula);
    echo "<br><br>Falta conectar con la base, eso lo terminamos en el avance 2.";
    echo "<br><a href='../view/vInicio/RegistrarUsuarios.php'>Volver</a>";
}

// recuperar acceso
if (isset($_POST["btnRecuperar"])) {

    $correo = $_POST['correo'] ?? '';

    echo "Solicitud recibida para: " . htmlspecialchars($correo);
    echo "<br><br>Falta el envio del correo, eso lo hacemos en el avance 2.";
    echo "<br><a href='../view/vInicio/RecuperarAcceso.php'>Volver</a>";
}
