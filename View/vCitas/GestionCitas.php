<?php
// gestion de todas las citas del sistema (solo administrador)
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/SeguridadController.php';
ValidarSesion(array('administrador'));

include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/CitasController.php';

$citas = CitasAdminControl();

$titulo_pagina = "Gestión de citas - MediSalud CR";
include_once '../LayoutInterno.php';
ImportCSS($titulo_pagina);
PintarHeader();
?>

<main class="panel-fondo">
    <div class="container-fluid" style="max-width:1300px;">

        <?php PintarMensaje(); ?>

        <h2 class="mb-3">Gestión de citas</h2>

        <div class="tarjeta-panel">
            <?php if (count($citas) === 0) { ?>
                <p>No hay citas registradas en el sistema.</p>
            <?php } else { ?>
                <div class="table-responsive">
                    <table class="table tabla-citas">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Paciente</th>
                                <th>Médico</th>
                                <th>Especialidad</th>
                                <th>Estado</th>
                                <th>Actualizar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($citas as $cita) { ?>
                                <tr>
                                    <td><?php echo $cita['id']; ?></td>
                                    <td><?php echo $cita['fecha']; ?></td>
                                    <td><?php echo substr($cita['hora'], 0, 5); ?></td>
                                    <td><?php echo htmlspecialchars($cita['paciente']); ?></td>
                                    <td><?php echo htmlspecialchars($cita['medico']); ?></td>
                                    <td><?php echo htmlspecialchars($cita['especialidad']); ?></td>
                                    <td><span class="badge-estado <?php echo ClaseEstado($cita['estado']); ?>">
                                        <?php echo htmlspecialchars($cita['estado']); ?></span></td>
                                    <td>
                                        <?php if ($cita['estado'] === 'Agendada') { ?>
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
