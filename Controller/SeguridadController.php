<?php
    // control de sesion, toda vista interna incluye este archivo primero

    // zona horaria del proyecto, para que las fechas salgan con hora de costa rica
    date_default_timezone_set('America/Costa_Rica');

    if (session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }

    // panel que le toca a cada rol
    function RutaPanel($rol)
    {
        if ($rol == 'administrador')
        {
            return '/MediSalud-CR/View/vPanel/PanelAdmin.php';
        }
        if ($rol == 'medico')
        {
            return '/MediSalud-CR/View/vPanel/PanelMedico.php';
        }
        return '/MediSalud-CR/View/vPanel/PanelPaciente.php';
    }

    // valida que haya sesion y que el rol tenga permiso
    // si $rolesPermitidos viene vacio basta con estar logueado
    function ValidarSesion($rolesPermitidos = array())
    {
        if (!isset($_SESSION['usuario_id']))
        {
            header("Location: /MediSalud-CR/View/vInicio/IniciarSesion.php?msj=" . urlencode("Debe iniciar sesión para continuar.") . "&tipo=error");
            exit();
        }

        if (count($rolesPermitidos) > 0 && !in_array($_SESSION['rol'], $rolesPermitidos))
        {
            header("Location: " . RutaPanel($_SESSION['rol']) . "?msj=" . urlencode("No tiene permisos para entrar a esa página.") . "&tipo=error");
            exit();
        }
    }
