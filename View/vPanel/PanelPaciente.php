<?php
// panel del paciente: resumen de sus proximas citas y accesos rapidos
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/SeguridadController.php';
ValidarSesion(array('paciente'));

include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/CitasController.php';

// solo las citas agendadas de hoy en adelante
$proximas = array();
foreach (CitasPacienteControl() as $cita) {
    if ($cita['estado'] === 'Agendada' && $cita['fecha'] >= date('Y-m-d')) {
        $proximas[] = $cita;
    }
}

$titulo_pagina = "Panel del paciente - MediSalud CR";
include_once '../LayoutInterno.php';
ImportCSS($titulo_pagina);
PintarHeader();
?>

<main class="panel-fondo">
    <div class="container">

        <?php PintarMensaje(); ?>

        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">Hola, <?php echo htmlspecialchars($_SESSION['nombre']); ?></h2>
            </div>
        </div>

        <div class="row">
            <!-- accesos rapidos -->
            <div class="col-lg-4">
                <div class="tarjeta-panel text-center">
                    <i class="fa fa-calendar-plus fa-2x mb-3" style="color:#244cb6;"></i>
                    <h5>Agendar una cita</h5>
                    <p>Reserve un espacio con el médico de su preferencia.</p>
                    <a href="../vCitas/AgendarCita.php" class="btn-medisalud" style="display:inline-block; text-decoration:none; width:auto; padding:10px 30px;">Agendar</a>
                </div>
                <div class="tarjeta-panel text-center">
                    <i class="fa fa-calendar-alt fa-2x mb-3" style="color:#244cb6;"></i>
                    <h5>Mis citas</h5>
                    <p>Consulte su historial y cancele si lo necesita.</p>
                    <a href="../vCitas/MisCitas.php" class="btn-medisalud-sec" style="display:inline-block; text-decoration:none;">Ver mis citas</a>
                </div>
            </div>

            <!-- proximas citas -->
            <div class="col-lg-8">
                <div class="tarjeta-panel">
                    <h5 class="mb-3"><i class="fa fa-clock" style="color:#244cb6;"></i> Próximas citas</h5>

                    <?php if (count($proximas) === 0) { ?>
                        <p>No tiene citas agendadas. ¡Reserve la suya!</p>
                    <?php } else { ?>
                        <div class="table-responsive">
                            <table class="table tabla-citas">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Médico</th>
                                        <th>Especialidad</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($proximas as $cita) { ?>
                                        <tr>
                                            <td><?php echo $cita['fecha']; ?></td>
                                            <td><?php echo substr($cita['hora'], 0, 5); ?></td>
                                            <td><?php echo htmlspecialchars($cita['medico']); ?></td>
                                            <td><?php echo htmlspecialchars($cita['especialidad']); ?></td>
                                            <td><span class="badge-estado <?php echo ClaseEstado($cita['estado']); ?>">
                                                <?php echo htmlspecialchars($cita['estado']); ?></span></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

    </div>
</main>

<?php
PintarFooter();
ImportJS();
?>
