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

// plantilla base para que todos los correos se vean iguales
function PlantillaCorreo($titulo, $contenidoHtml)
{
    return '
    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e0e6f0; border-radius: 8px; overflow: hidden;">
        <div style="background: #244cb6; color: #ffffff; padding: 20px 30px;">
            <h2 style="margin: 0;">Clínica MediSalud CR</h2>
        </div>
        <div style="padding: 30px; color: #3d4451;">
            <h3 style="color: #1f2c4d; margin-top: 0;">' . $titulo . '</h3>
            ' . $contenidoHtml . '
        </div>
        <div style="background: #f4f7fc; color: #5a6272; padding: 15px 30px; font-size: 12px;">
            Este es un mensaje automático del sistema de citas de MediSalud CR.
        </div>
    </div>';
}
