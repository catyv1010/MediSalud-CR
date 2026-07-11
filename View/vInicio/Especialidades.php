<?php
// pagina de especialidades
$titulo_pagina = "Especialidades - MediSalud CR";

// lista de prueba, despues la cargamos desde la base
$especialidades = [
    [
        "nombre" => "Medicina General",
        "ancla" => "esp-medicina-general",
        "descripcion" => "Atención integral, consulta de primer contacto, controles preventivos y referencia a especialidades.",
        "icono" => "flaticon-stethoscope",
        "color" => "#244cb6"
    ],
    [
        "nombre" => "Cardiología",
        "ancla" => "esp-cardiologia",
        "descripcion" => "Diagnóstico y tratamiento de enfermedades del corazón y el sistema circulatorio.",
        "icono" => "flaticon-heart",
        "color" => "#c00000"
    ],
    [
        "nombre" => "Pediatría",
        "ancla" => "esp-pediatria",
        "descripcion" => "Atención médica especializada para bebés, niños y adolescentes hasta los 18 años.",
        "icono" => "flaticon-baby",
        "color" => "#2e75b6"
    ],
    [
        "nombre" => "Dermatología",
        "ancla" => "esp-dermatologia",
        "descripcion" => "Cuidado de la piel, cabello y uñas: control de lunares, acné, alergias y procedimientos estéticos básicos.",
        "icono" => "flaticon-doctor",
        "color" => "#70ad47"
    ],
    [
        "nombre" => "Ginecología",
        "ancla" => "esp-ginecologia",
        "descripcion" => "Salud de la mujer en todas las etapas: controles, planificación familiar y seguimiento.",
        "icono" => "flaticon-doctor-2",
        "color" => "#9b59b6"
    ],
    [
        "nombre" => "Ortopedia",
        "ancla" => "esp-ortopedia",
        "descripcion" => "Diagnóstico y tratamiento de lesiones del sistema músculo-esquelético: huesos, articulaciones y tendones.",
        "icono" => "flaticon-bone",
        "color" => "#e67e22"
    ],
    [
        "nombre" => "Nutrición",
        "ancla" => "esp-nutricion",
        "descripcion" => "Acompañamiento nutricional, planes alimenticios personalizados y educación en hábitos saludables.",
        "icono" => "flaticon-apple",
        "color" => "#16a085"
    ],
];

include_once '../LayoutExterno.php';
ImportCSS($titulo_pagina);
PintarHeader();
?>

<main>
    <!-- encabezado -->
    <div class="bradcam-area" style="background:linear-gradient(120deg, #244cb6 0%, #2e75b6 100%); padding:100px 0;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-8 col-md-10 text-center" style="color:white;">
                    <h2 style="color:white;">Especialidades médicas</h2>
                    <p>Áreas clínicas que ofrecemos en la Clínica MediSalud CR</p>
                </div>
            </div>
        </div>
    </div>

    <!-- grid -->
    <section style="padding:70px 0; background:#f7faff;">
        <div class="container">
            <div class="row justify-content-center mb-50">
                <div class="col-lg-8 text-center">
                    <h3 style="color:#244cb6;">¿Qué especialidad necesita?</h3>
                    <p style="color:#666;">
                        Escoja el área clínica de su interés. Después de registrarse va a poder
                        ver los médicos de esa especialidad y agendar la cita.
                    </p>
                </div>
            </div>

            <div class="row">
                <?php foreach ($especialidades as $e): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div style="background:#ffffff; padding:42px 30px; border-radius:14px; height:100%; border-top:5px solid <?= $e['color'] ?>; box-shadow:0 6px 24px rgba(31,44,77,0.08);">
                            <div style="width:70px; height:70px; background:<?= $e['color'] ?>; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:20px;">
                                <i class="fa fa-plus-square" style="color:white; font-size:32px;"></i>
                            </div>
                            <h5 style="color:<?= $e['color'] ?>; font-size:23px; margin-bottom:12px;"><?= htmlspecialchars($e['nombre']) ?></h5>
                            <p style="color:#666; line-height:1.7; margin-bottom:20px;"><?= htmlspecialchars($e['descripcion']) ?></p>
                            <a href="Medicos.php#<?= $e['ancla'] ?>" style="color:<?= $e['color'] ?>; font-weight:bold; font-size:17px;">Ver médico &raquo;</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- info extra -->
    <section style="padding:60px 0; background:#f7faff;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h4 style="color:#244cb6;">Horario de atención</h4>
                    <p style="color:#666; line-height:1.8;">
                        <strong>Lunes a viernes:</strong> 7:00 a.m. - 7:00 p.m.<br>
                        <strong>Sábados:</strong> 8:00 a.m. - 2:00 p.m.<br>
                        <strong>Domingos y feriados:</strong> Cerrado
                    </p>
                </div>
                <div class="col-lg-6">
                    <h4 style="color:#244cb6;">¿Cómo agendar?</h4>
                    <p style="color:#666; line-height:1.8;">
                        Primero cree una cuenta, después escoja la especialidad y el médico, y
                        seleccione el horario disponible. Le llega la confirmación al correo.
                    </p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
PintarFooter();
ImportJS();
?>
