<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/CatalogosController.php';

// pagina de especialidades
$titulo_pagina = "Especialidades - MediSalud CR";

// el nombre, la descripcion, el icono y el color salen del catalogo de la base
$especialidades = EspecialidadesPublicoControl();

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
                <?php foreach ($especialidades as $e) { ?>
                    <?php
                        $color = htmlspecialchars($e['color']);
                        $ancla = "esp-" . $e['id'];
                    ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="tarjeta-especialidad" style="border-top-color:<?php echo $color; ?>;">
                            <div class="tarjeta-especialidad-icono" style="background:<?php echo $color; ?>;">
                                <i class="<?php echo htmlspecialchars($e['icono']); ?>"></i>
                            </div>
                            <h5 style="color:<?php echo $color; ?>;"><?php echo htmlspecialchars($e['nombre']); ?></h5>
                            <p><?php echo htmlspecialchars($e['descripcion'] ?? ''); ?></p>
                            <a href="Medicos.php#<?php echo $ancla; ?>" style="color:<?php echo $color; ?>;">Ver médicos &raquo;</a>
                        </div>
                    </div>
                <?php } ?>
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