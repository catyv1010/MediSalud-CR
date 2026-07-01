<?php
// historial de citas del paciente, con opcion de cancelar las agendadas
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/SeguridadController.php';
ValidarSesion(array('paciente'));

include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/CitasController.php';

$citas = CitasPacienteControl();

$titulo_pagina = "Mis citas - MediSalud CR";
include_once '../LayoutInterno.php';
ImportCSS($titulo_pagina);
PintarHeader();
?>

<main class="panel-fondo">
    <div class="container">

        <?php PintarMensaje(); ?>

        <div class="row align-items-center mb-3">
            <div class="col-md-8">
                <h2>Mis citas</h2>
            </div>
            <div class="col-md-4 text-md-right">
                <a href="AgendarCita.php" class="btn-medisalud" style="display:inline-block; text-decoration:none; width:auto; padding:10px 30px;">
                    <i class="fa fa-plus"></i> Nueva cita</a>
            </div>
        </div>

        <div class="tarjeta-panel">
            <?php if (count($citas) === 0) { ?>
                <p>Aún no ha agendado ninguna cita.</p>
            <?php } else { ?>
                <div class="table-responsive">
                    <table class="table tabla-citas">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Médico</th>
                                <th>Especialidad</th>
                                <th>Motivo</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($citas as $cita) { ?>
                                <tr>
                                    <td><?php echo $cita['fecha']; ?></td>
                                    <td><?php echo substr($cita['hora'], 0, 5); ?></td>
                                    <td><?php echo htmlspecialchars($cita['medico']); ?></td>
                                    <td><?php echo htmlspecialchars($cita['especialidad']); ?></td>
                                    <td><?php echo htmlspecialchars($cita['motivo'] ?? ''); ?></td>
                                    <td><span class="badge-estado <?php echo ClaseEstado($cita['estado']); ?>">
                                        <?php echo htmlspecialchars($cita['estado']); ?></span></td>
                                    <td>
                                        <?php if ($cita['estado'] === 'Agendada' && $cita['fecha'] >= date('Y-m-d')) { ?>
                                            <!-- cancelar: formulario pequeno que manda el id de la cita -->
                                            <form action="../../Controller/CitasController.php" method="POST" class="form-cancelar" style="display:inline;">
                                                <input type="hidden" name="cita_id" value="<?php echo $cita['id']; ?>">
                                                <button type="submit" name="btnCancelarCita" class="btn-medisalud-sec">Cancelar</button>
                                            </form>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <p style="color:#5a6272; font-size:13px; margin-top:10px;">
                    <i class="fa fa-info-circle"></i> Las citas solo pueden cancelarse con al menos 24 horas de anticipación.
                </p>
            <?php } ?>
        </div>

    </div>
</main>

<?php
PintarFooter();
ImportJS();
?>
