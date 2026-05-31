<?php
// recibe los datos del formulario de registro
// la insercion en la base la dejamos para el avance 2

$cedula = $_POST['cedula'] ?? '';
$nombre = $_POST['nombre'] ?? '';
$correo = $_POST['correo'] ?? '';

echo "Datos recibidos: " . htmlspecialchars($nombre) . " - " . htmlspecialchars($cedula);
echo "<br><br>Falta conectar con la base, eso lo terminamos en el avance 2.";
echo "<br><a href='../registro.php'>Volver</a>";
