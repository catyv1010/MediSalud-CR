<?php
// agenda completa del medico, con cambio de estado de las citas
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/SeguridadController.php';
ValidarSesion(array('medico'));

include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/CitasController.php';

$citas = CitasMedicoControl();

$titulo_pagina = "Mi agenda - MediSalud CR";
include_once '../LayoutInterno.php';
ImportCSS($titulo_pagina);
PintarHeader();
?>

<main class="panel-fondo">
    <div class="container">

        <?php PintarMensaje(); ?>

        <h2 class="mb-3">Mi agenda</h2>

        <div class="tarjeta-panel">
            <?php if (count($citas) === 0) { ?>
                <p>No tiene citas registradas.</p>
            <?php } else { ?>
                <div class="table-responsive">
                    <table class="table tabla-citas">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Paciente</th>
                                <th>Cédula</th>
                                <th>Motivo</th>
                                <th>Estado</th>
                                <th>Actualizar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($citas as $cita) { ?>
                                <tr>
                                    <td><?php echo $cita['fecha']; ?></td>
                                    <td><?php echo substr($cita['hora'], 0, 5); ?></td>
                                    <td><?php echo htmlspecialchars($cita['paciente']); ?></td>
                                    <td><?php echo htmlspecialchars($cita['cedula_paciente']); ?></td>
                                    <td><?php echo htmlspecialchars($cita['motivo'] ?? ''); ?></td>
                                    <td><span class="badge-estado <?php echo ClaseEstado($cita['estado']); ?>">
                                        <?php echo htmlspecialchars($cita['estado']); ?></span></td>
                                    <td>
                                        <?php if ($cita['estado'] === 'Agendada') { ?>
                                            <!-- cambio de estado: 2=Atendida, 3=Cancelada, 4=No asistio -->
                                            <form action="../../Controller/CitasController.php" method="POST" class="form-estado form-inline">
                                                <input type="hidden" name="cita_id" value="<?php echo $cita['id']; ?>">
                                                <select class="form-control form-control-sm mr-2" name="estado_id" required>
                                                    <option value="">Estado...</option>
                                                    <option value="2">Atendida</option>
                                                    <option value="3">Cancelada</option>
                                                    <option value="4">No asistió</option>
                                                </select>
                                                <button type="submit" name="btnActualizarEstado" class="btn-medisalud-sec">Guardar</button>
                                            </form>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>

    </div>
</main>

<?php
PintarFooter();
ImportJS();
?>
