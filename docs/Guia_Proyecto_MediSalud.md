# Guía completa del proyecto MediSalud CR

**Para qué sirve este documento:** es la referencia completa del proyecto para estudiar antes de la exposición y para responder cualquier pregunta del profesor. Si estás en otra computadora, abrí Claude (claude.ai), subí este archivo al chat y preguntale lo que ocupés — aquí está todo el contexto.

**Curso:** SC-502 Ambiente Web Cliente/Servidor — Universidad Fidélitas — Prof. Eduardo José Calvo Castillo
**Grupo 8:** Luis Andrés Granados González, Andrés Rojas Quesada, José Alexis Sandi Guillén, María Catalina Valverde Arroyo
**Proyecto:** Sistema web de gestión de citas médicas para la Clínica MediSalud CR (clínica privada ficticia)
**Última actualización:** 11 de julio de 2026 (alineado a la clase de semana 9)

---

## 1. Qué es el proyecto en una frase

Una aplicación web donde los pacientes agendan citas médicas en línea viendo la disponibilidad real de cada médico, los médicos administran su agenda, y un administrador mantiene los catálogos y genera reportes. Todo con PHP + MySQL en arquitectura MVC, con procedimientos almacenados y notificaciones por correo.

**El problema que resuelve:** en clínicas pequeñas las citas se agendan por teléfono o WhatsApp, lo que genera dobles citas, errores de recepción y pacientes que no logran comunicarse fuera de horario de oficina.

---

## 2. Tecnologías y dónde se usa cada una

| Tecnología | Dónde se usa en el proyecto |
|---|---|
| HTML5 | Estructura de todas las vistas (`View/`) |
| CSS3 + Bootstrap | Estilos y diseño responsive (`assets/css/`, plantilla + `medisalud.css` propio) |
| JavaScript + jQuery | Validaciones de formularios y AJAX (`assets/js/`) |
| jQuery Validate | Reglas de validación en el navegador (un archivo JS por formulario) |
| AJAX + JSON | Agendamiento en cascada: especialidad → médicos → horas libres, sin recargar la página |
| PHP | Toda la lógica del servidor: controladores y modelos |
| MySQL (MariaDB) | Base de datos `medisalud_cr`: 8 tablas y 33 procedimientos almacenados |
| PHPMailer | Envío de correos por SMTP de Gmail |
| Git / GitHub | Control de versiones del código |
| XAMPP | Servidor local: Apache en puerto **81**, MySQL en puerto **3307** |

**URL local:** `http://localhost:81/MediSalud-CR/`

---

## 3. Arquitectura MVC — la explicación que hay que saber dar

MVC separa el código en tres capas con responsabilidades distintas:

- **Vista (View):** lo que el usuario ve. Solo HTML/PHP de presentación. NUNCA habla directo con la base de datos.
- **Controlador (Controller):** recibe lo que el usuario envió, valida, decide qué hacer y a dónde redirigir.
- **Modelo (Model):** el único que habla con la base de datos, y siempre a través de procedimientos almacenados.

**El flujo completo (memorizá este ejemplo con el login):**

1. El usuario llena el formulario en `View/vInicio/IniciarSesion.php` y presiona el botón `btnLogin` (tipo `submit`).
2. Antes de enviarse, `assets/js/iniciarsesion.js` valida con jQuery Validate que los campos no estén vacíos.
3. El formulario hace POST a `Controller/InicioController.php`, que detecta el botón con `if (isset($_POST["btnLogin"]))`.
4. El controlador valida de nuevo en el servidor (porque lo del navegador se puede saltar) y llama al modelo: `IniciarSesionModel($identificacion, $contrasena)`.
5. El modelo (`Model/UsuariosModel.php`) abre la conexión con `OpenDB()`, ejecuta `CALL sp_iniciar_sesion(...)`, recorre el resultado con `fetch_assoc()`, cierra con `CloseDB()` y retorna los datos.
6. El procedimiento almacenado compara las credenciales en la base y devuelve el usuario solo si existe y está activo.
7. Si el login es válido, el controlador guarda nombre, rol e IDs en variables de sesión (`$_SESSION`) y redirige con `header("Location: ...")` al panel del rol.

**Regla de las 3 cosas para conectar vista con controlador (el profe la pregunta):**
1. Todos los campos llevan `name` (sin name, el controlador recibe nulo).
2. El `<form>` usa `method="POST"` y el botón es `type="submit"` con su propio `name` (ej. `btnLogin`).
3. El formulario apunta al controlador (en nuestro caso con `action="../../Controller/InicioController.php"`).

---

## 4. Estructura de carpetas y qué hace cada archivo

```
MediSalud-CR/
├── index.php                  → solo redirige a la pantalla principal
├── DataBase.sql               → crea la base completa (tablas + SPs + datos semilla)
├── .vscode/launch.json        → configuración para debuggear PHP con Xdebug
├── Controller/
│   ├── InicioController.php      → login, registro, logout (btnSalir), recuperar y cambiar contraseña
│   ├── CitasController.php       → agendar, cancelar, cambiar estado de citas
│   ├── CatalogosController.php   → CRUD de médicos, especialidades, horarios, usuarios
│   ├── SeguridadController.php   → ValidarSesion(roles) y RutaPanel(rol)
│   ├── UtilitarioController.php  → EnviarCorreo() y GenerarContrasena() (funciones reutilizables)
│   ├── ConfigCorreo.php          → configuración SMTP (la clave vive aparte en clave_correo.txt)
│   └── PHPMailer/                → librería de terceros para enviar correos
├── Model/
│   ├── UsuariosModel.php         → SPs de usuarios y autenticación
│   ├── CitasModel.php            → SPs de citas y disponibilidad
│   ├── MedicosModel.php          → SPs de médicos, especialidades y horarios
│   └── UtilitarioModel.php       → OpenDB(), CloseDB() y AddError() (conexión centralizada)
├── View/
│   ├── LayoutExterno.php         → header/footer/CSS/JS de las páginas públicas (antes de login)
│   ├── LayoutInterno.php         → header con menú por rol + botón Salir (zona autenticada)
│   ├── templates/                → plantillas HTML de los correos (Recuperacion, Bienvenida, CitaConfirmada)
│   ├── vInicio/                  → Principal, IniciarSesion, RegistrarUsuarios, RecuperarAcceso, AcercaDe, Medicos, Especialidades
│   ├── vPanel/                   → PanelPaciente, PanelMedico, PanelAdmin, CambiarContrasena
│   ├── vCitas/                   → AgendarCita, MisCitas, CitasMedico, GestionCitas, Calendario
│   └── vAdmin/                   → Medicos, EditarMedico, HorariosMedico, Especialidades, Usuarios, Reportes
└── assets/
    ├── css/medisalud.css         → estilos propios del proyecto (encima de la plantilla)
    └── js/                       → un archivo de validaciones por formulario + citas.js (AJAX)
```

**Puntos que el profe revisó y cómo los cumplimos:**
- Las vistas están dentro de la carpeta `View` ✓
- Las vistas NO tienen bloques de JavaScript: todo va en archivos externos que se cargan con `ImportJS()` ✓
- Los layouts concentran lo repetido (header, footer, imports) para no duplicar código ✓
- Sin errores en la consola del navegador (se reemplazó el `main.js` de la plantilla por `plantilla.js` propio que solo llama plugins existentes) ✓

---

## 5. Base de datos: `medisalud_cr` (8 tablas, 33 procedimientos)

### Tablas y para qué sirve cada una

| Tabla | Para qué sirve |
|---|---|
| `usuarios` | Tabla base de autenticación: id (PK), cédula (UNIQUE), correo (UNIQUE), contraseña, nombre, teléfono, rol, activo |
| `pacientes` | Perfil extra del rol paciente: fecha de nacimiento, género, dirección (FK a usuarios) |
| `especialidades` | Catálogo: nombre y descripción |
| `medicos` | Perfil extra del rol médico: especialidad (FK), número de colegiado, biografía (FK a usuarios) |
| `horarios_disponibles` | Franjas de atención de cada médico: día de la semana, hora inicio, hora fin |
| `citas` | La tabla central: paciente (FK), médico (FK), fecha, hora, estado (FK), motivo |
| `estados_cita` | Catálogo: Agendada, Atendida, Cancelada, No asistió |
| `errores` | Bitácora: cada excepción capturada se registra con mensaje, acción y usuario |

### Relaciones (para el diagrama ER)

- `usuarios` se especializa 1 a 1 en `pacientes` o `medicos` según el rol
- `especialidades` 1—N `medicos`
- `medicos` 1—N `horarios_disponibles`
- `citas` N—1 con `pacientes`, `medicos` y `estados_cita`

### Por qué las decisiones de diseño (preguntas típicas)

- **¿Por qué la PK es un id consecutivo y no la cédula?** Porque la PK no debe editarse nunca y una cédula puede cambiar o digitarse mal; además un índice entero es más rápido. La cédula y el correo van como UNIQUE.
- **¿Por qué procedimientos almacenados?** (1) Evitan SQL Injection porque en PHP no hay SQL concatenado, solo `CALL sp_x(...)`; (2) centralizan las reglas de negocio en la base; (3) son requisito del proyecto.
- **¿Cómo evitan la doble cita?** Doble validación: el frontend solo muestra horas libres, y el SP `sp_agendar_cita` vuelve a verificar que el bloque esté libre antes del INSERT. Si dos personas envían al mismo tiempo, la segunda recibe error.
- **¿La contraseña está encriptada?** Se guarda como VARCHAR igual que se vio en clase. Está identificado como trabajo futuro usar `SHA2()` de MySQL en los SPs de registro y login (respuesta honesta si pregunta).
- **La contraseña NUNCA se devuelve en un SELECT** — el SP de login compara adentro y devuelve los datos sin la contraseña.

### Procedimientos por área (33 en total)

- **Autenticación (5):** `sp_iniciar_sesion`, `sp_registrar_paciente`, `sp_validar_correo`, `sp_actualizar_contrasena`, `sp_cambiar_contrasena`
- **Catálogos y perfiles (16):** listar/crear/editar especialidades y médicos, franjas de horario, `sp_cambiar_estado_usuario`, etc.
- **Citas y calendario (9):** `sp_agendar_cita`, `sp_cancelar_cita` (exige 24 h), `sp_agenda_diaria_medico`, `sp_citas_del_mes`, cambio de estado, horas ocupadas
- **Reportes y bitácora (3):** `sp_reporte_mensual`, `sp_contadores_panel`, `sp_registrar_error`

---

## 6. Seguridad y sesiones (tema favorito del profe)

### Variables de sesión

- Se guardan **en el servidor**, no en el navegador. El navegador solo guarda una cookie con el `PHPSESSID` (el identificador); los datos reales nadie los puede ver ni modificar desde el browser. Esto las hace más seguras que cookies/localStorage/sessionStorage, donde todo es visible y modificable.
- Antes de leer o escribir `$_SESSION` siempre va `session_start()` (en nuestro código: `if (session_status() == PHP_SESSION_NONE) { session_start(); }`).
- Al loguear guardamos: `usuario_id`, `nombre`, `correo`, `rol`, y según el rol también `paciente_id` o `medico_id` + `especialidad`.
- Las sesiones se comparten entre pestañas del mismo navegador (mismo PHPSESSID), pero no entre navegadores distintos.

### Control de acceso por rol

Toda vista interna incluye primero `SeguridadController.php` y llama `ValidarSesion()`:
- Sin sesión activa → redirige al login (expulsa al intruso).
- Con sesión pero rol sin permiso → redirige a su propio panel con mensaje.
Además los controladores verifican pertenencia: un paciente solo cancela SUS citas, un médico solo actualiza las SUYAS.

### Cerrar sesión (como se vio en clase 9)

El botón "Salir" del menú es un `<button type="submit" name="btnSalir">` dentro de un form POST — NO un hipervínculo, porque un enlace obligaría a tener un archivo PHP con una única función. El controlador hace `session_unset()` + `session_destroy()` y redirige al login.

### Las 3 capas de validación

1. **Navegador:** jQuery Validate (rapidez y experiencia de usuario)
2. **Servidor (PHP):** se repiten las validaciones porque el navegador se puede saltar
3. **Base de datos:** UNIQUE, FKs y lógica de los SPs (la última línea de defensa)

### Bitácora de errores

Todos los `catch` llaman `AddError($error, $accion)`, que inserta en la tabla `errores` tomando el usuario de la sesión por sí solo. Así se diagnostican problemas sin mostrar detalles técnicos al usuario.

---

## 7. Correos electrónicos (lo de la clase 9)

- **Librería:** PHPMailer, dentro de `Controller/PHPMailer/` (la carpeta de controladores porque quien la usa es un controlador).
- **Servidor de salida:** `smtp.gmail.com`, puerto 587 con TLS. Se usa Gmail porque Office 365 ya no acepta usuario+contraseña simple.
- **Contraseña de aplicación:** NO es la contraseña del correo; se genera en https://myaccount.google.com/apppasswords (requiere verificación en dos pasos activada). Da acceso a la cuenta, por eso **no se sube al repo**: vive en `Controller/clave_correo.txt`, que está en `.gitignore`. Si el archivo no existe, los correos se escriben en `Controller/correos.log` (modo desarrollo).
- **Plantillas HTML:** en `View/templates/` hay un archivo HTML por tipo de correo (Recuperacion, Bienvenida, CitaConfirmada). El controlador lo lee con `file_get_contents()` y reemplaza los marcadores con `str_replace("{{NOMBRE}}", $nombre, $plantilla)`. Así el correo llega con diseño y no como texto plano feo.
- **Los 3 correos del sistema:** bienvenida al registrarse, comprobante al agendar cita, y contraseña temporal al recuperar acceso.
- **¿Por qué llegan a spam?** Porque salen de un servidor local sin certificado ni reputación. En producción se resolvería con un dominio propio y registros SPF/DKIM.

### Recuperación de contraseña — los 3 pasos

1. `sp_validar_correo`: ¿el correo existe y la cuenta está activa? (devuelve id y nombre)
2. `GenerarContrasena()`: crea una temporal alfanumérica de 8 caracteres y `sp_actualizar_contrasena` la guarda
3. `EnviarCorreo()`: la envía con la plantilla HTML

El mensaje en pantalla es el mismo exista o no el correo — para no revelar qué correos están registrados (seguridad).

---

## 8. AJAX y jQuery (agendamiento de citas)

El agendamiento funciona en cascada sin recargar la página:

1. El paciente elige **especialidad** → `$.ajax` pide a `CitasController` los médicos de esa especialidad → la respuesta llega en **JSON** → jQuery llena el select de médicos.
2. Elige **médico y fecha** → otro AJAX pide las horas disponibles.
3. El servidor calcula los bloques de **30 minutos** a partir de las franjas de `horarios_disponibles`, descartando las horas ya reservadas y las horas pasadas.
4. Al enviar, el SP revalida que el bloque siga libre.

**Validaciones de formularios:** cada formulario tiene su archivo JS con `$("#formulario").validate({ rules, messages })`. Desde la clase 9 se agregó el estilo visual: `errorElement: "div"` con clase `invalid-feedback` y `highlight/unhighlight` que ponen borde rojo (`is-invalid`) o verde (`is-valid`) a las cajas.

---

## 9. Módulos y flujos por rol

### Paciente
- Se registra (correo de bienvenida) e inicia sesión
- Agenda citas viendo disponibilidad real (comprobante por correo)
- Ve sus citas próximas e históricas; cancela con mínimo 24 h de anticipación
- Cambia su contraseña (requiere la actual)

### Médico
- Ve su agenda diaria con datos de contacto de cada paciente
- Marca citas como Atendida / Cancelada / No asistió (solo las suyas)

### Administrador
- Panel con contadores (pacientes activos, médicos, citas agendadas y del día)
- CRUD de médicos (con su usuario), especialidades y franjas de horario
- Activa/desactiva usuarios (no puede desactivarse a sí mismo)
- Reporte mensual por médico y especialidad + calendario mensual con estados por color

### Usuarios de prueba (datos semilla del DataBase.sql)

| Rol | Cédula | Contraseña |
|---|---|---|
| Administrador | 101110111 | Admin123* |
| Médicos | (ver semilla) | Medico123* |
| Pacientes | (ver semilla) | Paciente123* |

El login acepta **cédula O correo** en el mismo campo (el SP compara contra ambos).

---

## 10. Preguntas probables del profe y respuestas cortas

**¿Por qué MVC?** Separa responsabilidades: la vista muestra, el controlador decide, el modelo persiste. Facilita mantener y repartir el trabajo en equipo sin pisarse.

**¿Qué pasa si le mando el formulario sin llenar campos, saltándome el JavaScript?** El controlador repite las validaciones en PHP y la base tiene UNIQUE y NOT NULL. Tres capas.

**¿Dónde está el SQL del sistema?** En la base de datos, dentro de los 33 procedimientos almacenados. En PHP solo hay `CALL sp_x(...)` — cero SQL concatenado, cero inyección.

**¿Cómo funciona la sesión entre páginas?** PHP genera un PHPSESSID que viaja en cookie; los datos viven en el servidor. Cada archivo que use `$_SESSION` hace `session_start()` primero.

**¿Por qué el botón Salir no es un enlace?** Porque un hipervínculo tendría que llamar a un PHP de función única. Como botón submit entra al controlador de inicio con `isset($_POST["btnSalir"])`, igual que el resto de funcionalidades.

**¿Cómo envían correos?** PHPMailer + SMTP de Gmail con contraseña de aplicación. Plantillas HTML con `file_get_contents` + `str_replace`. La clave no está en el repo.

**¿Cómo debuggean?** Xdebug + la extensión PHP Debug de VS Code con el `launch.json` del repo: breakpoints, F10 (avanzar línea), F11 (entrar al método), F5 (soltar). Ahí se ven las variables y las sesiones en vivo.

**¿Qué harían diferente / trabajo futuro?** Hash de contraseñas con SHA2, recordatorios automáticos el día antes de la cita, publicar en un hosting, expediente básico del paciente.

**¿Cómo se reparte el trabajo el grupo?** Somos 4 (Sebastián Solano salió del curso). Módulos repartidos: Luis Andrés (agendamiento y mis citas), Andrés (agenda del médico), José Alexis (catálogos), Caty (reportes, frontend y documentación). La autenticación que llevaba Sebastián se completó entre todos siguiendo lo visto en clase.

---

## 11. Cómo correr el proyecto en cualquier compu

1. Instalar XAMPP; configurar Apache en puerto 81 y MySQL en 3307 (o ajustar `UtilitarioModel.php` y `URL_BASE` a los puertos locales)
2. Clonar el repo dentro de `C:\xampp\htdocs\` (la carpeta debe llamarse `MediSalud-CR` porque las rutas absolutas usan ese nombre)
3. Abrir MySQL Workbench → File → Open SQL Script → `DataBase.sql` → ejecutar todo (crea `medisalud_cr` desde cero)
4. Para correos reales: crear contraseña de aplicación de Gmail y pegarla en `Controller\clave_correo.txt` (sin ese archivo, los correos van a `correos.log`)
5. Entrar a `http://localhost:81/MediSalud-CR/`

**Regla del profe:** al terminar de trabajar, backup de la base y Stop al servicio MySQL (si la compu se apaga con MySQL corriendo, la base local se puede corromper).

---

## 12. Cronología de lo que hemos hecho (por si preguntan el proceso)

- **Semanas 1–4:** plantilla HTML/CSS/Bootstrap, 4 vistas base, estructura MVC inicial. Práctica 1 entregada (95%: observaciones de JS externo, consola y colores — ya corregidas). Avance 1 del documento IEEE (100%: observación de ampliar requerimientos — ya corregida).
- **Semanas 5–6:** base de datos MySQL, procedimientos almacenados, login y registro reales, bitácora de errores, validaciones jQuery.
- **Semanas 7–8:** recuperación de contraseña con temporal de 8 caracteres, PHPMailer, variables de sesión, roles, y todos los módulos: citas con AJAX, catálogos, reportes, calendario.
- **Semana 9 (esta):** envío real por Gmail con contraseña de aplicación, plantillas HTML de correos, cierre de sesión con botón POST, vista cambiar contraseña pulida, debugging con Xdebug, validaciones con estilo Bootstrap, contraste de textos, guía IEEE ampliada (requerimientos detallados + no funcionales), salida de Sebastián reflejada en documentos.
- **Próximo hito:** II Avance en semana 11 (15%, sin documentación, meta 60–70% del proyecto — ya lo superamos). Entrega final semana 15 (25%, exposición máx. 10 min).

---

*Documento generado con Claude el 11/07/2026. Copias en: Dropbox → Proyectos/Proyecto_Final/ y en el repo MediSalud-CR → docs/. Si lo actualizás, actualizá ambas.*
