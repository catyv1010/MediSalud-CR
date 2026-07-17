# MediSalud CR

SC-502 Ambiente Web Cliente Servidor - Grupo 8

- Luis Andrés Granados González
- Andrés Rojas Quesada
- José Alexis Sandi Guillén
- María Catalina Valverde Arroyo

## Instalación

1. Clonar el repositorio dentro de `C:\xampp\htdocs\` (la carpeta debe llamarse `MediSalud-CR`).
2. Importar `DataBase.sql` en MySQL Workbench. Crea la base `medisalud_cr` completa con procedimientos almacenados y datos de prueba.
3. Levantar Apache y MySQL desde XAMPP. La conexión usa MySQL en el puerto 3307, como se trabaja en el curso (se ajusta en `Model/UtilitarioModel.php` si hace falta).
4. Abrir `http://localhost:81/MediSalud-CR/` (cambiar el 81 por el puerto de Apache de su equipo).

## Usuarios de prueba

| Rol | Correo | Contraseña |
| --- | --- | --- |
| Administrador | admin@medisaludcr.example | Admin123* |
| Médico | lgarcia@medisaludcr.example | Medico123* |
| Paciente | ana.mora@correo.example | Paciente123* |

También se puede iniciar sesión con la cédula en lugar del correo.

## Correos

Sin configurar nada, los correos del sistema se guardan en `Controller/correos.log` para poder probar en local. Para envío real por Gmail se crea una contraseña de aplicación en https://myaccount.google.com/apppasswords y se pega en `Controller/clave_correo.txt` (ese archivo está en el `.gitignore` y nunca se sube al repositorio).

## Notas

- El registro y la pantalla de mi perfil completan el nombre automáticamente con el API de cédulas (https://apis.gometa.org/cedulas), por lo que se debe registrar con una cédula costarricense real.
- Los usuarios de prueba tienen cédulas ficticias, por eso su nombre no coincide con el API; se usan solo para la demo.
