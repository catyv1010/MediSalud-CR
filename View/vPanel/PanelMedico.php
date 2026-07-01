<?php
// panel del medico: su agenda de hoy
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/SeguridadController.php';
ValidarSesion(array('medico'));

include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/CitasController.php';

$agendaHoy = AgendaHoyMedicoControl();

$titulo_pagina = "Panel del médico - MediSalud CR";
include_once '../LayoutInterno.php';
ImportCSS($titulo_pagina);
PintarHeader();
?>

<main class="panel-fondo">
    <div class="container">

        <?php PintarMensaje(); ?>

        <div class="row">
            <div class="col-md-8">
                <h2><?php echo htmlspecialchars($_SESSION['nombre']); ?></h2>
                <p style="color:#5a6272;">Especialidad: <strong><?php echo htmlspecialchars($_SESSION['especialidad'] ?? ''); ?></strong></p>
            </div>
            <div class="col-md-4">
                <div class="tarjeta-contador">
                    <p class="numero"><?php echo count($agendaHoy); ?></p>
                    <p class="etiqueta">Citas para hoy (<?php echo date('d/m/Y'); ?>)</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="tarjeta-panel">
                    <h5 class="mb-3"><i class="fa fa-calendar-day" style="color:#244cb6;"></i> Agenda de hoy</h5>

                    <?php if (count($agendaHoy) === 0) { ?>
                        <p>No tiene citas programadas para hoy.</p>
                    <?php } else { ?>
                        <div class="table-responsive">
                            <table class="table tabla-citas">
                                <thead>
                                    <tr>
                                        <th>Hora</th>
                                        <th>Paciente</th>
                                        <th>Cédula</th>
                                        <th>Teléfono</th>
                                        <th>Motivo</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($agendaHoy as $cita) { ?>
                                        <tr>
                                            <td><?php echo substr($cita['hora'], 0, 5); ?></td>
                                            <td><?php echo htmlspecialchars($cita['paciente']); ?></td>
                                            <td><?php echo htmlspecialchars($cita['cedula_paciente']); ?></td>
                                            <td><?php echo htmlspecialchars($cita['telefono_paciente'] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($cita['motivo'] ?? ''); ?></td>
                                            <td><span class="badge-estado <?php echo ClaseEstado($cita['estado']); ?>">
                                                <?php echo htmlspecialchars($cita['estado']); ?></span></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>

                    <a href="../vCitas/CitasMedico.php" class="btn-medisalud-sec" style="display:inline-block; text-decoration:none;">Ver toda mi agenda</a>
                </div>
            </div>
        </div>

    </div>
</main>

<?php
PintarFooter();
ImportJS();
?>
