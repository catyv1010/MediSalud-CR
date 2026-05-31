<?php
// pagina de medicos
$titulo_pagina = "Médicos - MediSalud CR";

// lista de prueba, despues la cargamos desde la base
$medicos = [
    [
        "nombre" => "Dra. Ana Lucía Mora Vargas",
        "especialidad" => "Medicina General",
        "colegiado" => "MED-12453",
        "color" => "#244cb6",
        "iniciales" => "AM"
    ],
    [
        "nombre" => "Dr. Carlos Esteban Jiménez Salas",
        "especialidad" => "Cardiología",
        "colegiado" => "MED-08977",
        "color" => "#c00000",
        "iniciales" => "CJ"
    ],
    [
        "nombre" => "Dra. María Fernanda Rojas Castro",
        "especialidad" => "Pediatría",
        "colegiado" => "MED-15321",
        "color" => "#2e75b6",
        "iniciales" => "MR"
    ],
    [
        "nombre" => "Dr. José Andrés Picado Solano",
        "especialidad" => "Dermatología",
        "colegiado" => "MED-11204",
        "color" => "#70ad47",
        "iniciales" => "JP"
    ],
    [
        "nombre" => "Dra. Laura Patricia Quirós Méndez",
        "especialidad" => "Ginecología",
        "colegiado" => "MED-09845",
        "color" => "#9b59b6",
        "iniciales" => "LQ"
    ],
    [
        "nombre" => "Dr. Roberto Antonio Vega Ramírez",
        "especialidad" => "Ortopedia",
        "colegiado" => "MED-13702",
        "color" => "#e67e22",
        "iniciales" => "RV"
    ],
];

include 'view/_partials/header.php';
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

            <div class="row">
                <?php foreach ($medicos as $m): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div style="background:white; border-radius:8px; box-shadow:0 4px 15px rgba(0,0,0,0.06); overflow:hidden; height:100%;">
                            <div style="background:<?= $m['color'] ?>; padding:40px; text-align:center;">
                                <div style="width:100px; height:100px; background:white; border-radius:50%; margin:0 auto; display:flex; align-items:center; justify-content:center;">
                                    <span style="color:<?= $m['color'] ?>; font-size:36px; font-weight:bold;"><?= $m['iniciales'] ?></span>
                                </div>
                            </div>
                            <div style="padding:25px;">
                                <h5 style="color:#244cb6; margin-bottom:8px;"><?= htmlspecialchars($m['nombre']) ?></h5>
                                <p style="color:#666; margin-bottom:5px;"><strong>Especialidad:</strong> <?= htmlspecialchars($m['especialidad']) ?></p>
                                <p style="color:#999; font-size:13px; margin-bottom:18px;">Colegiado: <?= htmlspecialchars($m['colegiado']) ?></p>
                                <a href="login.php" class="btn" style="background:<?= $m['color'] ?>; color:white; width:100%; padding:10px;">Ver agenda</a>
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
            <a href="registro.php" class="btn header-btn mt-3" style="background:white; color:#244cb6;">Crear cuenta</a>
        </div>
    </section>
</main>

<?php include 'view/_partials/footer.php'; ?>
