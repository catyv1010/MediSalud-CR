<?php
// recibe el correo para recuperar acceso
// el envio del correo lo agregamos en el avance 2

$correo = $_POST['correo'] ?? '';

echo "Solicitud recibida para: " . htmlspecialchars($correo);
echo "<br><br>Falta el envio del correo, eso lo hacemos en el avance 2.";
echo "<br><a href='../recuperar.php'>Volver</a>";
