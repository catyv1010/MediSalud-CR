<?php
// Layout de las vistas con sesion iniciada (zona interna).
// Ojo: una vista incluye este o el externo, no los dos (las funciones se llaman igual).
// Toda vista interna debe incluir antes el SeguridadController y llamar ValidarSesion().

// head con los css, abre el body
function ImportCSS($titulo = 'MediSalud CR')
{
    echo '<!DOCTYPE html>
<html class="no-js" lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>' . htmlspecialchars($titulo) . '</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/favicon.ico">
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/medisalud.css">
</head>
<body>
';
}

// barra superior con el usuario, su rol y el menu segun el rol
function PintarHeader()
{
    $nombre = htmlspecialchars($_SESSION['nombre'] ?? '');
    $rol    = $_SESSION['rol'] ?? '';

    // opciones de menu por rol
    $enlaces = '<a href="' . RutaPanel($rol) . '"><i class="fa fa-home"></i> Panel</a>';

    if ($rol === 'paciente') {
        $enlaces .= '<a href="/MediSalud-CR/View/vCitas/AgendarCita.php"><i class="fa fa-calendar-plus"></i> Agendar cita</a>';
        $enlaces .= '<a href="/MediSalud-CR/View/vCitas/MisCitas.php"><i class="fa fa-calendar-alt"></i> Mis citas</a>';
    }
    if ($rol === 'medico') {
        $enlaces .= '<a href="/MediSalud-CR/View/vCitas/CitasMedico.php"><i class="fa fa-calendar-alt"></i> Mi agenda</a>';
    }
    if ($rol === 'administrador') {
        $enlaces .= '<a href="/MediSalud-CR/View/vCitas/GestionCitas.php"><i class="fa fa-calendar-alt"></i> Citas</a>';
        $enlaces .= '<a href="/MediSalud-CR/View/vCitas/Calendario.php"><i class="fa fa-calendar"></i> Calendario</a>';
        $enlaces .= '<a href="/MediSalud-CR/View/vAdmin/Medicos.php"><i class="fa fa-user-md"></i> Médicos</a>';
        $enlaces .= '<a href="/MediSalud-CR/View/vAdmin/Especialidades.php"><i class="fa fa-stethoscope"></i> Especialidades</a>';
        $enlaces .= '<a href="/MediSalud-CR/View/vAdmin/Usuarios.php"><i class="fa fa-users"></i> Usuarios</a>';
        $enlaces .= '<a href="/MediSalud-CR/View/vAdmin/Reportes.php"><i class="fa fa-chart-bar"></i> Reportes</a>';
    }

    $enlaces .= '<a href="/MediSalud-CR/View/vPanel/CambiarContrasena.php"><i class="fa fa-key"></i> Contraseña</a>';

    echo '
<header>
    <div class="nav-interna">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-8 col-md-7">
                    <strong style="color:#ffffff; font-size:20px; margin-right:25px;">MediSalud CR</strong>
                    ' . $enlaces . '
                </div>
                <div class="col-lg-4 col-md-5 text-right usuario-sesion">
                    <i class="fa fa-user-circle"></i> ' . $nombre . '
                    <span class="rol">' . htmlspecialchars($rol) . '</span>
                    <a href="/MediSalud-CR/Controller/InicioController.php?accion=logout"
                       style="color:#ffd6d6; margin-left:15px;">
                       <i class="fa fa-sign-out-alt"></i> Salir</a>
                </div>
            </div>
        </div>
    </div>
</header>
';
}

// pie de pagina de la zona interna
function PintarFooter()
{
    echo '
<footer class="text-center" style="padding:20px 0; background:#1f3864;">
    <p style="margin:0;">&copy; ' . date('Y') . ' Clínica MediSalud CR — Grupo 8 — SC-502</p>
</footer>
';
}

// scripts y cierre del html (todo js va en archivos externos)
// $extras: javascripts propios de la vista (ej. las validaciones de su formulario)
function ImportJS($extras = array())
{
    echo '
<script src="../../assets/js/vendor/jquery-1.12.4.min.js"></script>
<script src="../../assets/js/popper.min.js"></script>
<script src="../../assets/js/bootstrap.min.js"></script>
<script src="../../assets/js/jquery.validate.min.js"></script>
<script src="../../assets/js/citas.js"></script>
';

    foreach ($extras as $script) {
        echo '<script src="' . $script . '"></script>
';
    }

    echo '
</body>
</html>
';
}

// pinta un mensaje de exito o error si viene en la URL (?msj=...&tipo=ok|error)
function PintarMensaje()
{
    if (isset($_GET['msj']) && $_GET['msj'] !== '') {
        $tipo  = (isset($_GET['tipo']) && $_GET['tipo'] === 'ok') ? 'success' : 'danger';
        echo '<div class="alert alert-' . $tipo . ' text-center" role="alert">'
           . htmlspecialchars($_GET['msj'])
           . '</div>';
    }
}

// clase css del badge segun el estado de la cita
function ClaseEstado($estado)
{
    if ($estado === 'Agendada')  return 'estado-agendada';
    if ($estado === 'Atendida')  return 'estado-atendida';
    if ($estado === 'Cancelada') return 'estado-cancelada';
    return 'estado-no-asistio';
}
