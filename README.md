# MediSalud CR

Sistema web para agendar citas médicas en la Clínica MediSalud CR.

Curso: SC-502 Ambiente Web Cliente/Servidor
V Cuatrimestre 2026 - Universidad Fidélitas
Grupo 8

## Integrantes

- Granados González Luis Andrés
- Rojas Quesada Andrés
- Sandi Guillén José Alexis
- Solano Escalante Sebastián
- Valverde Arroyo María Catalina

## Cómo correr el proyecto

1. Tener XAMPP instalado con Apache encendido.
2. Copiar la carpeta del proyecto dentro de `C:\xampp\htdocs\`.
3. En el navegador entrar a `http://localhost/MediSalud/` (o con el puerto que XAMPP esté usando).
4. Debería aparecer la pantalla de inicio.

## Datos para probar el login

Mientras no haya base, en el login se puede entrar con:

- Usuario: `admin`
- Contraseña: `12345`

(Esto sale en el mismo formulario para no andar adivinando.)

## Estructura de carpetas

```
MediSalud/
  index.php              pantalla de inicio
  login.php              iniciar sesion
  registro.php           registro de pacientes
  recuperar.php          recuperar contrasena
  about.php              acerca de la clinica
  doctor.php             listado de medicos
  department.php         listado de especialidades

  view/_partials/
    header.php           cabecera comun
    footer.php           pie comun

  control/               aqui van los controladores (avance 2)
  model/                 aqui van los modelos (avance 2)

  assets/                css, js, imagenes y fuentes de la plantilla

  README.md
```

## Lo que tiene esta entrega (Practica 1)

La practica vale 5% y se trata del diseño grafico:

- Plantilla en HTML, CSS, JS y Bootstrap.
- Personalizada al tema de la clinica (logo, colores, textos en español).
- Las 4 vistas obligatorias en .php: inicio, login, registro y recuperar.
- Estructura de carpetas para Modelo-Vista-Controlador.
- Corre sin errores en la consola del navegador.

## Lo que falta para los siguientes avances

- Avance 2 (semana 9): conectar el formulario con la base, hacer los procedimientos almacenados y validaciones.
- Avance final (semana 14): envio de correos, reportes y prueba completa.

## Plantilla usada

Partimos de una plantilla gratuita llamada "Medical Center". Los archivos
dentro de `assets/` vienen de esa plantilla. Le cambiamos los colores, los
textos y el logo para que coincida con MediSalud CR.
