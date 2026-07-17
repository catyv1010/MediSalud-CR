-- Base de datos Clinica MediSalud CR - Avance 2
-- Grupo 8 - SC-502
-- ojo: borra la base si ya existe, para poder reinstalarla limpia

DROP DATABASE IF EXISTS medisalud_cr;

CREATE DATABASE medisalud_cr
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE medisalud_cr;


-- tabla base de usuarios, de aqui salen pacientes y medicos segun el rol
CREATE TABLE usuarios (
  id              INT AUTO_INCREMENT PRIMARY KEY,
  cedula          VARCHAR(20)  NOT NULL UNIQUE,
  correo          VARCHAR(150) NOT NULL UNIQUE,
  contrasena      VARCHAR(20)  NOT NULL,
  nombre          VARCHAR(150) NOT NULL,
  telefono        VARCHAR(20),
  rol             ENUM('paciente','medico','administrador') NOT NULL,
  activo          BOOLEAN      NOT NULL DEFAULT TRUE,
  fecha_registro  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- datos extra del paciente
CREATE TABLE pacientes (
  id               INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id       INT NOT NULL UNIQUE,
  fecha_nacimiento DATE,
  genero           ENUM('M','F','Otro'),
  direccion        VARCHAR(255),
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- catalogo de especialidades de la clinica
CREATE TABLE especialidades (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  nombre      VARCHAR(100) NOT NULL UNIQUE,
  descripcion TEXT
) ENGINE=InnoDB;

-- datos extra del medico
CREATE TABLE medicos (
  id                INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id        INT NOT NULL UNIQUE,
  especialidad_id   INT NOT NULL,
  numero_colegiado  VARCHAR(50) NOT NULL UNIQUE,
  biografia         TEXT,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (especialidad_id) REFERENCES especialidades(id)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

-- dias y horas en que atiende cada medico
CREATE TABLE horarios_disponibles (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  medico_id    INT NOT NULL,
  dia_semana   ENUM('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo') NOT NULL,
  hora_inicio  TIME NOT NULL,
  hora_fin     TIME NOT NULL,
  FOREIGN KEY (medico_id) REFERENCES medicos(id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- estados que puede tener una cita
CREATE TABLE estados_cita (
  id     INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- cada cita reservada
CREATE TABLE citas (
  id              INT AUTO_INCREMENT PRIMARY KEY,
  paciente_id     INT NOT NULL,
  medico_id       INT NOT NULL,
  fecha           DATE     NOT NULL,
  hora            TIME     NOT NULL,
  estado_id       INT      NOT NULL DEFAULT 1,
  motivo          TEXT,
  fecha_creacion  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (paciente_id) REFERENCES pacientes(id)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY (medico_id) REFERENCES medicos(id)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY (estado_id) REFERENCES estados_cita(id)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

-- bitacora de errores del sistema (mismo esquema que vimos en clase)
CREATE TABLE errores (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  mensaje    TEXT,
  accion     VARCHAR(100),
  usuario_id INT,
  fecha      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;


-- catalogos
INSERT INTO estados_cita (nombre) VALUES
  ('Agendada'),
  ('Atendida'),
  ('Cancelada'),
  ('No asistio');

INSERT INTO especialidades (nombre, descripcion) VALUES
  ('Medicina General',  'Atencion medica general para todas las edades'),
  ('Pediatria',         'Atencion medica de ninos y adolescentes'),
  ('Ginecologia',       'Salud reproductiva femenina'),
  ('Dermatologia',      'Diagnostico y tratamiento de enfermedades de la piel'),
  ('Ortopedia',         'Diagnostico y tratamiento del sistema musculoesqueletico'),
  ('Nutricion',         'Asesoria nutricional y planes alimentarios');


-- usuarios de prueba para la demo
INSERT INTO usuarios (cedula, correo, contrasena, nombre, telefono, rol) VALUES
  ('101110111', 'admin@medisaludcr.example',   'Admin123*',    'Administrador del Sistema', '2222-0001', 'administrador'),
  ('202220222', 'lgarcia@medisaludcr.example', 'Medico123*',   'Dra. Laura Garcia Mora',    '2222-0002', 'medico'),
  ('303330333', 'jrojas@medisaludcr.example',  'Medico123*',   'Dr. Jorge Rojas Solano',    '2222-0003', 'medico'),
  ('404440444', 'mvargas@medisaludcr.example', 'Medico123*',   'Dra. Maria Vargas Leon',    '2222-0004', 'medico'),
  ('505550555', 'ana.mora@correo.example',     'Paciente123*', 'Ana Mora Jimenez',          '8888-0005', 'paciente'),
  ('606660666', 'carlos.soto@correo.example',  'Paciente123*', 'Carlos Soto Ramirez',       '8888-0006', 'paciente');

INSERT INTO pacientes (usuario_id, fecha_nacimiento, genero, direccion) VALUES
  (5, '1995-03-12', 'F', 'San Jose, Curridabat'),
  (6, '1988-11-02', 'M', 'Heredia, San Pablo');

INSERT INTO medicos (usuario_id, especialidad_id, numero_colegiado, biografia) VALUES
  (2, 1, 'MED-1001', 'Medica general con 10 anos de experiencia en atencion primaria.'),
  (3, 2, 'MED-1002', 'Pediatra, especialista en desarrollo infantil.'),
  (4, 4, 'MED-1003', 'Dermatologa, miembro del colegio de medicos desde 2012.');

INSERT INTO horarios_disponibles (medico_id, dia_semana, hora_inicio, hora_fin) VALUES
  (1, 'Lunes',     '08:00:00', '12:00:00'),
  (1, 'Miercoles', '08:00:00', '12:00:00'),
  (1, 'Viernes',   '13:00:00', '17:00:00'),
  (2, 'Martes',    '08:00:00', '12:00:00'),
  (2, 'Jueves',    '13:00:00', '17:00:00'),
  (3, 'Lunes',     '13:00:00', '17:00:00'),
  (3, 'Miercoles', '13:00:00', '17:00:00'),
  (3, 'Viernes',   '08:00:00', '12:00:00');

-- unas citas de ejemplo para que los paneles no salgan vacios
INSERT INTO citas (paciente_id, medico_id, fecha, hora, estado_id, motivo) VALUES
  (1, 1, '2026-06-24', '09:00:00', 2, 'Control general anual'),
  (1, 3, '2026-07-06', '13:30:00', 1, 'Revision de lunar en el brazo'),
  (2, 1, '2026-07-08', '08:30:00', 1, 'Dolor de cabeza recurrente'),
  (2, 2, '2026-06-25', '14:00:00', 3, 'Consulta pediatrica para su hijo');


-- procedimientos almacenados
-- en PHP no va SQL suelto, todo se llama con CALL

DELIMITER //

-- verifica las credenciales y devuelve el usuario si es valido
-- acepta cedula o correo como identificacion
CREATE PROCEDURE sp_iniciar_sesion(
  IN p_identificacion VARCHAR(150),
  IN p_contrasena     VARCHAR(20)
)
BEGIN
  SELECT id, cedula, correo, nombre, rol
  FROM usuarios
  WHERE (cedula = p_identificacion OR correo = p_identificacion)
    AND contrasena = p_contrasena
    AND activo = TRUE;
END //


-- registra un paciente: crea el usuario y su perfil
-- va en transaccion para que no quede a medias si algo falla
CREATE PROCEDURE sp_registrar_paciente(
  IN p_cedula           VARCHAR(20),
  IN p_correo           VARCHAR(150),
  IN p_contrasena       VARCHAR(20),
  IN p_nombre           VARCHAR(150),
  IN p_telefono         VARCHAR(20),
  IN p_fecha_nacimiento DATE,
  IN p_genero           VARCHAR(10),
  IN p_direccion        VARCHAR(255)
)
BEGIN
  DECLARE v_usuario_id INT;
  DECLARE EXIT HANDLER FOR SQLEXCEPTION
  BEGIN
    ROLLBACK;
    RESIGNAL;
  END;

  START TRANSACTION;

  INSERT INTO usuarios (cedula, correo, contrasena, nombre, telefono, rol)
  VALUES (p_cedula, p_correo, p_contrasena, p_nombre, p_telefono, 'paciente');

  SET v_usuario_id = LAST_INSERT_ID();

  INSERT INTO pacientes (usuario_id, fecha_nacimiento, genero, direccion)
  VALUES (v_usuario_id, p_fecha_nacimiento, p_genero, p_direccion);

  COMMIT;

  SELECT v_usuario_id AS usuario_id;
END //


-- valida que el correo exista y este activo (para la recuperacion)
-- devuelve los datos del usuario, incluido el id para actualizarle la contrasena
CREATE PROCEDURE sp_validar_correo(
  IN p_correo VARCHAR(150)
)
BEGIN
  SELECT id, nombre, correo
  FROM usuarios
  WHERE correo = p_correo
    AND activo = TRUE;
END //


-- le pone al usuario la contrasena temporal que se le envia por correo
CREATE PROCEDURE sp_actualizar_contrasena(
  IN p_usuario_id INT,
  IN p_contrasena VARCHAR(20)
)
BEGIN
  UPDATE usuarios SET contrasena = p_contrasena WHERE id = p_usuario_id;
  SELECT 'OK' AS resultado;
END //


-- cambio de contrasena con sesion iniciada (valida la actual)
CREATE PROCEDURE sp_cambiar_contrasena(
  IN p_usuario_id INT,
  IN p_actual     VARCHAR(20),
  IN p_nueva      VARCHAR(20)
)
BEGIN
  DECLARE v_existe INT DEFAULT 0;

  SELECT COUNT(*) INTO v_existe
  FROM usuarios
  WHERE id = p_usuario_id AND contrasena = p_actual;

  IF v_existe = 0 THEN
    SELECT 'ACTUAL_INCORRECTA' AS resultado;
  ELSE
    UPDATE usuarios SET contrasena = p_nueva WHERE id = p_usuario_id;
    SELECT 'OK' AS resultado;
  END IF;
END //


-- datos del usuario logueado, para precargar la pantalla de mi perfil
CREATE PROCEDURE sp_consultar_usuario(
  IN p_usuario_id INT
)
BEGIN
  SELECT id, cedula, nombre, correo, telefono
  FROM usuarios
  WHERE id = p_usuario_id;
END //


-- actualiza los datos personales desde la pantalla de mi perfil
CREATE PROCEDURE sp_actualizar_perfil(
  IN p_usuario_id INT,
  IN p_cedula     VARCHAR(20),
  IN p_nombre     VARCHAR(150),
  IN p_correo     VARCHAR(150),
  IN p_telefono   VARCHAR(20)
)
BEGIN
  UPDATE usuarios
  SET cedula   = p_cedula,
      nombre   = p_nombre,
      correo   = p_correo,
      telefono = p_telefono
  WHERE id = p_usuario_id;

  SELECT 'OK' AS resultado;
END //



-- especialidades para llenar los selects
CREATE PROCEDURE sp_listar_especialidades()
BEGIN
  SELECT id, nombre, descripcion
  FROM especialidades
  ORDER BY nombre;
END //


-- medicos de una especialidad (lo consume el llamado ajax de agendar)
CREATE PROCEDURE sp_medicos_por_especialidad(
  IN p_especialidad_id INT
)
BEGIN
  SELECT m.id, u.nombre
  FROM medicos m
  INNER JOIN usuarios u ON m.usuario_id = u.id
  WHERE m.especialidad_id = p_especialidad_id
    AND u.activo = TRUE
  ORDER BY u.nombre;
END //


-- perfil de paciente de un usuario (se guarda en la sesion)
CREATE PROCEDURE sp_obtener_paciente(
  IN p_usuario_id INT
)
BEGIN
  SELECT id AS paciente_id
  FROM pacientes
  WHERE usuario_id = p_usuario_id;
END //


-- perfil de medico de un usuario (se guarda en la sesion)
CREATE PROCEDURE sp_obtener_medico(
  IN p_usuario_id INT
)
BEGIN
  SELECT m.id AS medico_id, m.especialidad_id, e.nombre AS especialidad
  FROM medicos m
  INNER JOIN especialidades e ON m.especialidad_id = e.id
  WHERE m.usuario_id = p_usuario_id;
END //


-- franjas de atencion configuradas para un medico
CREATE PROCEDURE sp_franjas_medico(
  IN p_medico_id INT
)
BEGIN
  SELECT id, dia_semana, hora_inicio, hora_fin
  FROM horarios_disponibles
  WHERE medico_id = p_medico_id
  ORDER BY FIELD(dia_semana,'Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo'), hora_inicio;
END //


-- horas ya reservadas de un medico en una fecha
CREATE PROCEDURE sp_horas_ocupadas(
  IN p_medico_id INT,
  IN p_fecha     DATE
)
BEGIN
  SELECT hora
  FROM citas
  WHERE medico_id = p_medico_id
    AND fecha     = p_fecha
    AND estado_id IN (1, 2);
END //


-- crea la cita validando que el horario este libre
CREATE PROCEDURE sp_agendar_cita(
  IN p_paciente_id INT,
  IN p_medico_id   INT,
  IN p_fecha       DATE,
  IN p_hora        TIME,
  IN p_motivo      TEXT
)
BEGIN
  DECLARE v_existe INT DEFAULT 0;

  SELECT COUNT(*) INTO v_existe
  FROM citas
  WHERE medico_id = p_medico_id
    AND fecha     = p_fecha
    AND hora      = p_hora
    AND estado_id IN (1, 2);

  IF v_existe > 0 THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Ya existe una cita reservada en ese horario';
  ELSE
    INSERT INTO citas (paciente_id, medico_id, fecha, hora, motivo, estado_id)
    VALUES (p_paciente_id, p_medico_id, p_fecha, p_hora, p_motivo, 1);

    SELECT LAST_INSERT_ID() AS cita_id;
  END IF;
END //


-- cancela una cita si faltan al menos 24 horas
CREATE PROCEDURE sp_cancelar_cita(
  IN p_cita_id INT
)
BEGIN
  DECLARE v_fecha DATE;
  DECLARE v_hora  TIME;
  DECLARE v_horas INT;

  SELECT fecha, hora INTO v_fecha, v_hora
  FROM citas WHERE id = p_cita_id;

  SET v_horas = TIMESTAMPDIFF(HOUR, NOW(), CONCAT(v_fecha, ' ', v_hora));

  IF v_horas < 24 THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'No se puede cancelar con menos de 24 horas de anticipacion';
  ELSE
    UPDATE citas SET estado_id = 3 WHERE id = p_cita_id;
    SELECT 'OK' AS resultado;
  END IF;
END //


-- citas del paciente, proximas e historicas
CREATE PROCEDURE sp_listar_citas_paciente(
  IN p_paciente_id INT
)
BEGIN
  SELECT
    c.id, c.fecha, c.hora, c.motivo,
    ec.nombre AS estado,
    u.nombre  AS medico,
    e.nombre  AS especialidad
  FROM citas c
  INNER JOIN medicos m        ON c.medico_id       = m.id
  INNER JOIN usuarios u       ON m.usuario_id      = u.id
  INNER JOIN especialidades e ON m.especialidad_id = e.id
  INNER JOIN estados_cita ec  ON c.estado_id       = ec.id
  WHERE c.paciente_id = p_paciente_id
  ORDER BY c.fecha DESC, c.hora DESC;
END //


-- agenda completa del medico
CREATE PROCEDURE sp_listar_citas_medico(
  IN p_medico_id INT
)
BEGIN
  SELECT
    c.id, c.fecha, c.hora, c.motivo,
    ec.nombre   AS estado,
    up.nombre   AS paciente,
    up.cedula   AS cedula_paciente,
    up.telefono AS telefono_paciente
  FROM citas c
  INNER JOIN pacientes p     ON c.paciente_id = p.id
  INNER JOIN usuarios  up    ON p.usuario_id  = up.id
  INNER JOIN estados_cita ec ON c.estado_id   = ec.id
  WHERE c.medico_id = p_medico_id
  ORDER BY c.fecha DESC, c.hora ASC;
END //


-- agenda del dia para el panel del medico
CREATE PROCEDURE sp_agenda_diaria_medico(
  IN p_medico_id INT,
  IN p_fecha     DATE
)
BEGIN
  SELECT
    c.id, c.hora, c.motivo,
    ec.nombre   AS estado,
    up.nombre   AS paciente,
    up.cedula   AS cedula_paciente,
    up.telefono AS telefono_paciente
  FROM citas c
  INNER JOIN pacientes p     ON c.paciente_id = p.id
  INNER JOIN usuarios  up    ON p.usuario_id  = up.id
  INNER JOIN estados_cita ec ON c.estado_id   = ec.id
  WHERE c.medico_id = p_medico_id
    AND c.fecha     = p_fecha
  ORDER BY c.hora ASC;
END //


-- todas las citas del sistema, para el administrador
CREATE PROCEDURE sp_listar_citas_admin()
BEGIN
  SELECT
    c.id, c.fecha, c.hora, c.motivo,
    ec.nombre AS estado,
    up.nombre AS paciente,
    um.nombre AS medico,
    e.nombre  AS especialidad
  FROM citas c
  INNER JOIN pacientes p      ON c.paciente_id     = p.id
  INNER JOIN usuarios  up     ON p.usuario_id      = up.id
  INNER JOIN medicos   m      ON c.medico_id       = m.id
  INNER JOIN usuarios  um     ON m.usuario_id      = um.id
  INNER JOIN especialidades e ON m.especialidad_id = e.id
  INNER JOIN estados_cita ec  ON c.estado_id       = ec.id
  ORDER BY c.fecha DESC, c.hora ASC;
END //


-- cambia el estado de una cita (2=Atendida, 3=Cancelada, 4=No asistio)
CREATE PROCEDURE sp_actualizar_estado_cita(
  IN p_cita_id   INT,
  IN p_estado_id INT
)
BEGIN
  UPDATE citas SET estado_id = p_estado_id WHERE id = p_cita_id;
  SELECT 'OK' AS resultado;
END //


-- datos completos de una cita, para el correo de confirmacion
-- y para revisar que la cita sea de quien la esta tocando
CREATE PROCEDURE sp_datos_cita(
  IN p_cita_id INT
)
BEGIN
  SELECT
    c.id, c.fecha, c.hora, c.motivo,
    ec.nombre AS estado,
    p.id      AS paciente_id,
    up.id     AS paciente_usuario_id,
    up.nombre AS paciente,
    up.correo AS correo_paciente,
    m.id      AS medico_id,
    um.id     AS medico_usuario_id,
    um.nombre AS medico,
    e.nombre  AS especialidad
  FROM citas c
  INNER JOIN pacientes p      ON c.paciente_id     = p.id
  INNER JOIN usuarios  up     ON p.usuario_id      = up.id
  INNER JOIN medicos   m      ON c.medico_id       = m.id
  INNER JOIN usuarios  um     ON m.usuario_id      = um.id
  INNER JOIN especialidades e ON m.especialidad_id = e.id
  INNER JOIN estados_cita ec  ON c.estado_id       = ec.id
  WHERE c.id = p_cita_id;
END //


-- contadores para las tarjetas del panel del administrador
CREATE PROCEDURE sp_contadores_panel()
BEGIN
  SELECT
    (SELECT COUNT(*) FROM usuarios WHERE rol = 'paciente' AND activo = TRUE) AS total_pacientes,
    (SELECT COUNT(*) FROM usuarios WHERE rol = 'medico'   AND activo = TRUE) AS total_medicos,
    (SELECT COUNT(*) FROM citas    WHERE estado_id = 1)                      AS citas_agendadas,
    (SELECT COUNT(*) FROM citas    WHERE fecha = CURDATE())                  AS citas_hoy;
END //


-- reporte mensual de citas por medico y especialidad (avance 1)
CREATE PROCEDURE sp_reporte_mensual(
  IN p_mes  INT,
  IN p_anio INT
)
BEGIN
  SELECT
    e.nombre AS especialidad,
    u.nombre AS medico,
    COUNT(*) AS total_citas,
    SUM(CASE WHEN c.estado_id = 2 THEN 1 ELSE 0 END) AS atendidas,
    SUM(CASE WHEN c.estado_id = 3 THEN 1 ELSE 0 END) AS canceladas,
    SUM(CASE WHEN c.estado_id = 4 THEN 1 ELSE 0 END) AS no_asistio
  FROM citas c
  INNER JOIN medicos m        ON c.medico_id       = m.id
  INNER JOIN usuarios u       ON m.usuario_id      = u.id
  INNER JOIN especialidades e ON m.especialidad_id = e.id
  WHERE MONTH(c.fecha) = p_mes
    AND YEAR (c.fecha) = p_anio
  GROUP BY e.nombre, u.nombre
  ORDER BY total_citas DESC;
END //


-- guarda un error en la bitacora (mismo patron del repo de clase)
CREATE PROCEDURE sp_registrar_error(
  IN p_mensaje    TEXT,
  IN p_accion     VARCHAR(100),
  IN p_usuario_id INT
)
BEGIN
  INSERT INTO errores (mensaje, accion, usuario_id)
  VALUES (p_mensaje, p_accion, p_usuario_id);
END //


-- citas de un mes para pintar el calendario
CREATE PROCEDURE sp_citas_del_mes(
  IN p_mes  INT,
  IN p_anio INT
)
BEGIN
  SELECT
    c.fecha, c.hora,
    ec.nombre AS estado,
    up.nombre AS paciente,
    um.nombre AS medico
  FROM citas c
  INNER JOIN pacientes p     ON c.paciente_id = p.id
  INNER JOIN usuarios  up    ON p.usuario_id  = up.id
  INNER JOIN medicos   m     ON c.medico_id   = m.id
  INNER JOIN usuarios  um    ON m.usuario_id  = um.id
  INNER JOIN estados_cita ec ON c.estado_id   = ec.id
  WHERE MONTH(c.fecha) = p_mes
    AND YEAR (c.fecha) = p_anio
  ORDER BY c.fecha, c.hora;
END //


-- crud de especialidades (administrador)
CREATE PROCEDURE sp_crear_especialidad(
  IN p_nombre      VARCHAR(100),
  IN p_descripcion TEXT
)
BEGIN
  INSERT INTO especialidades (nombre, descripcion)
  VALUES (p_nombre, p_descripcion);
  SELECT LAST_INSERT_ID() AS especialidad_id;
END //


CREATE PROCEDURE sp_actualizar_especialidad(
  IN p_id          INT,
  IN p_nombre      VARCHAR(100),
  IN p_descripcion TEXT
)
BEGIN
  UPDATE especialidades
  SET nombre = p_nombre, descripcion = p_descripcion
  WHERE id = p_id;
  SELECT 'OK' AS resultado;
END //


-- si la especialidad tiene medicos la llave foranea no deja borrarla
CREATE PROCEDURE sp_eliminar_especialidad(
  IN p_id INT
)
BEGIN
  DELETE FROM especialidades WHERE id = p_id;
  SELECT 'OK' AS resultado;
END //


-- lista de medicos para la pantalla del administrador
CREATE PROCEDURE sp_listar_medicos_admin()
BEGIN
  SELECT
    m.id, m.numero_colegiado, m.especialidad_id,
    u.id AS usuario_id, u.cedula, u.nombre, u.correo, u.telefono, u.activo,
    e.nombre AS especialidad
  FROM medicos m
  INNER JOIN usuarios u       ON m.usuario_id      = u.id
  INNER JOIN especialidades e ON m.especialidad_id = e.id
  ORDER BY u.nombre;
END //


-- crea el usuario y el perfil del medico en una transaccion
CREATE PROCEDURE sp_crear_medico(
  IN p_cedula          VARCHAR(20),
  IN p_correo          VARCHAR(150),
  IN p_contrasena      VARCHAR(20),
  IN p_nombre          VARCHAR(150),
  IN p_telefono        VARCHAR(20),
  IN p_especialidad_id INT,
  IN p_colegiado       VARCHAR(50)
)
BEGIN
  DECLARE v_usuario_id INT;
  DECLARE EXIT HANDLER FOR SQLEXCEPTION
  BEGIN
    ROLLBACK;
    RESIGNAL;
  END;

  START TRANSACTION;

  INSERT INTO usuarios (cedula, correo, contrasena, nombre, telefono, rol)
  VALUES (p_cedula, p_correo, p_contrasena, p_nombre, p_telefono, 'medico');

  SET v_usuario_id = LAST_INSERT_ID();

  INSERT INTO medicos (usuario_id, especialidad_id, numero_colegiado)
  VALUES (v_usuario_id, p_especialidad_id, p_colegiado);

  COMMIT;

  SELECT v_usuario_id AS usuario_id;
END //


-- actualiza los datos del medico y de su usuario
CREATE PROCEDURE sp_actualizar_medico(
  IN p_medico_id       INT,
  IN p_nombre          VARCHAR(150),
  IN p_telefono        VARCHAR(20),
  IN p_especialidad_id INT,
  IN p_colegiado       VARCHAR(50)
)
BEGIN
  UPDATE medicos m
  INNER JOIN usuarios u ON m.usuario_id = u.id
  SET u.nombre           = p_nombre,
      u.telefono         = p_telefono,
      m.especialidad_id  = p_especialidad_id,
      m.numero_colegiado = p_colegiado
  WHERE m.id = p_medico_id;
  SELECT 'OK' AS resultado;
END //


-- lista de usuarios del sistema (administrador)
CREATE PROCEDURE sp_listar_usuarios()
BEGIN
  SELECT id, cedula, nombre, correo, telefono, rol, activo
  FROM usuarios
  ORDER BY rol, nombre;
END //


-- activa o desactiva un usuario (0 o 1)
CREATE PROCEDURE sp_cambiar_estado_usuario(
  IN p_usuario_id INT,
  IN p_activo     INT
)
BEGIN
  UPDATE usuarios SET activo = p_activo WHERE id = p_usuario_id;
  SELECT 'OK' AS resultado;
END //


-- agrega una franja de atencion a un medico
CREATE PROCEDURE sp_agregar_horario(
  IN p_medico_id   INT,
  IN p_dia_semana  VARCHAR(10),
  IN p_hora_inicio TIME,
  IN p_hora_fin    TIME
)
BEGIN
  INSERT INTO horarios_disponibles (medico_id, dia_semana, hora_inicio, hora_fin)
  VALUES (p_medico_id, p_dia_semana, p_hora_inicio, p_hora_fin);
  SELECT LAST_INSERT_ID() AS horario_id;
END //


-- elimina una franja de atencion
CREATE PROCEDURE sp_eliminar_horario(
  IN p_horario_id INT
)
BEGIN
  DELETE FROM horarios_disponibles WHERE id = p_horario_id;
  SELECT 'OK' AS resultado;
END //

DELIMITER ;
