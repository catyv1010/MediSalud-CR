<?php

    // configuracion del correo (smtp de gmail)
    // la contrasena de aplicacion NO va aqui: se lee de Controller/clave_correo.txt,
    // que esta en el .gitignore para que nunca se suba al repositorio
    // cada integrante crea su clave en https://myaccount.google.com/apppasswords
    // y la pega en su propio clave_correo.txt
    // si el archivo no existe o esta vacio, los correos se guardan en Controller/correos.log

    $rutaClave = __DIR__ . '/clave_correo.txt';
    $claveCorreo = file_exists($rutaClave) ? trim(file_get_contents($rutaClave)) : '';

    define('SMTP_CONTRASENA', $claveCorreo);
    define('CORREO_ACTIVO', $claveCorreo != '');

    define('SMTP_HOST',       'smtp.gmail.com');
    define('SMTP_PUERTO',     587);
    define('SMTP_USUARIO',    'irenea2130@gmail.com');

    define('CORREO_REMITENTE', 'irenea2130@gmail.com');
    define('NOMBRE_REMITENTE', 'Clinica MediSalud CR');

    // base de los enlaces que van dentro de los correos (apache en el 81)
    define('URL_BASE', 'http://localhost:81/MediSalud-CR');
