<?php

    // configuracion del correo (smtp de gmail)
    // para activarlo: crear una contrasena de aplicacion en
    // https://myaccount.google.com/apppasswords, pegarla abajo
    // y cambiar CORREO_ACTIVO a true
    // mientras este en false los correos se guardan en Controller/correos.log
    // ojo: no subir este archivo con la contrasena real a un repo publico

    define('CORREO_ACTIVO', false);

    define('SMTP_HOST',       'smtp.gmail.com');
    define('SMTP_PUERTO',     587);
    define('SMTP_USUARIO',    'cvalverde21@gmail.com');
    define('SMTP_CONTRASENA', 'PEGAR_AQUI_CONTRASENA_DE_APLICACION');

    define('CORREO_REMITENTE', 'cvalverde21@gmail.com');
    define('NOMBRE_REMITENTE', 'Clinica MediSalud CR');

    // base de los enlaces que van dentro de los correos (apache en el 81)
    define('URL_BASE', 'http://localhost:81/MediSalud-CR');
