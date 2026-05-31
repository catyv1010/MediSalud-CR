<?php
// recibe los datos del login
// la conexion con la base la armamos en el avance 2

$cedula = $_POST['cedula'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';

echo "Datos recibidos: " . htmlspecialchars($cedula);
echo "<br><br>Esta parte queda lista para el avance 2 cuando conectemos con MySQL.";
echo "<br><a href='../login.php'>Volver</a>";
