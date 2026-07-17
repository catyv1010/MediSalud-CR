<?php
// controlador utilitario: funciones reutilizables por los demas controladores
// (generar contrasenas temporales y enviar correos con phpmailer)

include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/ConfigCorreo.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/PHPMailer/PHPMailer.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/PHPMailer/SMTP.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/PHPMailer/Exception.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Model/UtilitarioModel.php';

use PHPMailer\PHPMailer\PHPMailer;

// genera una contrasena temporal de 8 caracteres (mayusculas y numeros)
function GenerarContrasena()
{
    $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $contrasena = '';

    for ($i = 0; $i < 8; $i++) {
        $contrasena .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }

    return $contrasena;
}

// destruye la sesion, se usa al salir y despues de cambiar la contrasena
function CerrarSesion()
{
    if (session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }

    session_unset();
    session_destroy();
}

// envia un correo html con phpmailer
// si CORREO_ACTIVO esta en false lo escribe en correos.log para poder probar en local
function EnviarCorreo($destino, $nombreDestino, $asunto, $cuerpoHtml)
{
    if (!CORREO_ACTIVO) {
        $linea = "==== " . date('Y-m-d H:i:s') . " ====\n"
               . "Para: $nombreDestino <$destino>\n"
               . "Asunto: $asunto\n"
               . strip_tags(str_replace(array('<br>', '<br/>', '<br />'), "\n", $cuerpoHtml))
               . "\n\n";
        file_put_contents(__DIR__ . '/correos.log', $linea, FILE_APPEND);
        return true;
    }

    try
    {
        $mail = new PHPMailer(true);

        // conexion con el servidor de gmail
        $mail -> isSMTP();
        $mail -> Host       = SMTP_HOST;
        $mail -> SMTPAuth   = true;
        $mail -> Username   = SMTP_USUARIO;
        $mail -> Password   = SMTP_CONTRASENA;
        $mail -> SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail -> Port       = SMTP_PUERTO;
        $mail -> CharSet    = 'UTF-8';

        $mail -> setFrom(CORREO_REMITENTE, NOMBRE_REMITENTE);
        $mail -> addAddress($destino, $nombreDestino);

        $mail -> isHTML(true);
        $mail -> Subject = $asunto;
        $mail -> Body    = $cuerpoHtml;

        $mail -> send();
        return true;
    }
    catch(Exception $e)
    {
        AddError($e, 'EnviarCorreo');
        return false;
    }
}

// las plantillas de los correos viven en View/templates como archivos html
// cada controlador las lee con file_get_contents y reemplaza los valores
// {{NOMBRE}}, {{TEMPORAL}}, etc. con str_replace antes de llamar EnviarCorreo
