<?php
// pagina de medicos
$titulo_pagina = "Médicos - MediSalud CR";

// lista de prueba, despues la cargamos desde la base
// cada medico tiene su propia foto en assets/img/medicos
// el ancla permite llegar directo a cada medico desde la pagina de especialidades
$medicos = [
    [
        "nombre" => "Dra. Ana Lucía Mora Vargas",
        "especialidad" => "Medicina General",
        "colegiado" => "MED-12453",
        "foto" => "../../assets/img/medicos/medico1.jpg",
        "ancla" => "esp-medicina-general"
    ],
    [
        "nombre" => "Dr. Carlos Esteban Jiménez Salas",
        "especialidad" => "Cardiología",
        "colegiado" => "MED-08977",
        "foto" => "../../assets/img/medicos/medico2.jpg",
        "ancla" => "esp-cardiologia"
    ],
    [
        "nombre" => "Dra. María Fernanda Rojas Castro",
        "especialidad" => "Pediatría",
        "colegiado" => "MED-15321",
        "foto" => "../../assets/img/medicos/medico3.jpg",
        "ancla" => "esp-pediatria"
    ],
    [
        "nombre" => "Dr. José Andrés Picado Solano",
        "especialidad" => "Dermatología",
        "colegiado" => "MED-11204",
        "foto" => "../../assets/img/medicos/medico4.jpg",
        "ancla" => "esp-dermatologia"
    ],
    [
        "nombre" => "Dra. Laura Patricia Quirós Méndez",
        "especialidad" => "Ginecología",
        "colegiado" => "MED-09845",
        "foto" => "../../assets/img/medicos/medico5.jpg",
        "ancla" => "esp-ginecologia"
    ],
    [
        "nombre" => "Dr. Roberto Antonio Vega Ramírez",
        "especialidad" => "Ortopedia",
        "colegiado" => "MED-13702",
        "foto" => "../../assets/img/medicos/medico6.jpg",
        "ancla" => "esp-ortopedia"
    ],
    [
        "nombre" => "Dr. Esteban Josué Ulate Brenes",
        "especialidad" => "Nutrición",
        "colegiado" => "CPN-04512",
        "foto" => "../../assets/img/medicos/medico7.jpg",
        "ancla" => "esp-nutricion"
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
                    <h2 style="color:white;">Nuestros médicos</h2>
                    <p>Profesionales colegiados al servicio de su salud</p>
                </div>
            </div>
        </div>
    </div>

    <!-- listado -->
    <section style="padding:80px 0; background:#f7faff;">
        <div class="container">
            <div class="row justify-content-center mb-50">
                <div class="col-lg-8 text-center">
                    <h3 style="color:#244cb6;">Equipo médico</h3>
                    <p style="color:#666;">
                        Todos los médicos están colegiados ante el Colegio de Médicos y Cirujanos
                        de Costa Rica. Escoja uno para ver su agenda y reservar su cita.
                    </p>
                </div>
            </div>

            <div class="row justify-content-center">
                <?php foreach ($medicos as $m): ?>
                    <div class="col-lg-4 col-md-6 mb-4 tarjeta-medico-ancla" id="<?= $m['ancla'] ?>">
                        <div class="tarjeta-medico">
                            <div class="tarjeta-medico-foto">
                                <img src="<?= $m['foto'] ?>" alt="<?= htmlspecialchars($m['nombre']) ?>">
                            </div>
                            <div class="tarjeta-medico-info">
                                <h5><?= htmlspecialchars($m['nombre']) ?></h5>
                                <p class="especialidad"><?= htmlspecialchars($m['especialidad']) ?></p>
                                <p class="colegiado">Colegiado: <?= htmlspecialchars($m['colegiado']) ?></p>
                                <a href="IniciarSesion.php" class="btn-medisalud">Ver agenda</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- llamado a registrarse -->
    <section style="padding:60px 0; background:linear-gradient(120deg, #244cb6 0%, #2e75b6 100%); color:white; text-align:center;">
        <div class="container">
            <h3 style="color:white;">¿Listo para agendar su cita?</h3>
            <p>Regístrese gratis y reserve con el médico de su preferencia.</p>
            <a href="RegistrarUsuarios.php" class="btn header-btn mt-3" style="background:white; color:#244cb6;">Crear cuenta</a>
        </div>
    </section>
</main>

<?php
PintarFooter();
ImportJS();
?>
