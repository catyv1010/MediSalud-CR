<?php
// pantalla principal
$titulo_pagina = "MediSalud CR - Clínica MediSalud CR";
include_once '../LayoutExterno.php';
ImportCSS($titulo_pagina);
PintarHeader();
?>

<main>
    <!-- banner principal -->
    <div class="slider-area position-relative">
        <div class="slider-active">
            <div class="single-slider slider-height d-flex align-items-center" style="background-image:url(../../assets/img/hero/h1_hero.png); background-size:cover; background-position:center;">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-7 col-lg-9 col-md-10">
                            <div class="hero__caption">
                                <span data-animation="fadeInLeft" data-delay=".4s">Clínica MediSalud CR</span>
                                <h1 data-animation="fadeInLeft" data-delay=".6s">Agende su cita médica en línea</h1>
                                <p data-animation="fadeInLeft" data-delay=".8s">
                                    Consulte la disponibilidad de nuestros médicos las veinticuatro horas
                                    del día, reserve su cita en pocos pasos y reciba la confirmación
                                    directamente en su correo electrónico.
                                </p>
                                <a href="RegistrarUsuarios.php" data-animation="fadeInLeft" data-delay="1.0s" class="btn hero-btn">Crear cuenta</a>
                                <a href="IniciarSesion.php" data-animation="fadeInLeft" data-delay="1.2s" class="btn hero-btn" style="margin-left:10px;">Iniciar sesión</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- servicios -->
    <div class="categories-area section-padding30">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10">
                    <div class="section-tittle text-center mb-55">
                        <span>Nuestros servicios</span>
                        <h2>¿Qué puede hacer en MediSalud CR?</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="single-cat text-center mb-50">
                        <div class="cat-icon"><i class="ti-calendar"></i></div>
                        <div class="cat-cap">
                            <h5>Agendar citas en línea</h5>
                            <p>Reserve consultas con cualquiera de nuestros especialistas a cualquier hora del día, sin necesidad de llamar a la recepción.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="single-cat text-center mb-50">
                        <div class="cat-icon"><i class="ti-user"></i></div>
                        <div class="cat-cap">
                            <h5>Consultar a sus médicos</h5>
                            <p>Conozca el perfil de cada médico, su especialidad y los horarios disponibles antes de reservar la cita.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="single-cat text-center mb-50">
                        <div class="cat-icon"><i class="ti-email"></i></div>
                        <div class="cat-cap">
                            <h5>Recordatorios automáticos</h5>
                            <p>Reciba la confirmación y el recordatorio de su cita por correo electrónico, para no olvidar su consulta.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- especialidades -->
    <div class="department-area section-padding30" style="background:#f7faff;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10">
                    <div class="section-tittle text-center mb-55">
                        <span>Especialidades</span>
                        <h2>Médicos para toda la familia</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                $especialidades = [
                    ['Medicina General',  'Atención médica para todas las edades', 'ti-heart'],
                    ['Pediatría',         'Atención de niños y adolescentes',     'ti-shine'],
                    ['Ginecología',       'Salud reproductiva femenina',          'ti-user'],
                    ['Dermatología',      'Diagnóstico de enfermedades de la piel','ti-eye'],
                    ['Ortopedia',         'Sistema musculoesquelético',           'ti-pulse'],
                    ['Nutrición',         'Asesoría nutricional personalizada',    'ti-apple'],
                ];
                foreach ($especialidades as $esp): ?>
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="single-cat text-center mb-30" style="background:white; padding:30px; border-radius:8px;">
                        <div class="cat-icon"><i class="<?= $esp[2] ?>"></i></div>
                        <div class="cat-cap">
                            <h5><?= $esp[0] ?></h5>
                            <p><?= $esp[1] ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- CTA registro -->
    <div class="make-app-area pt-150 pb-150" style="background:#244cb6;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-9 col-md-10 text-center" style="color:white;">
                    <h2 style="color:white;">¿Listo para agendar su primera cita?</h2>
                    <p>Cree su cuenta en menos de un minuto y reserve con el médico de su preferencia.</p>
                    <a href="RegistrarUsuarios.php" class="btn hero-btn">Registrarse</a>
                </div>
            </div>
        </div>
    </div>

</main>

<?php
PintarFooter();
ImportJS();
?>
