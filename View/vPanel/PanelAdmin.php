<?php
// panel del administrador: contadores generales y ultimas citas
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/SeguridadController.php';
ValidarSesion(array('administrador'));

include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/CitasController.php';

$contadores = ContadoresControl();
$ultimas    = array_slice(CitasAdminControl(), 0, 8);

$titulo_pagina = "Panel de administración - MediSalud CR";
include_once '../LayoutInterno.php';
ImportCSS($titulo_pagina);
PintarHeader();
?>

<main class="panel-fondo">
    <div class="container">

        <?php PintarMensaje(); ?>

        <h2 class="mb-4">Panel de administración</h2>

        <!-- contadores -->
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="tarjeta-contador">
                    <p class="numero"><?php echo $contadores['total_pacientes'] ?? 0; ?></p>
                    <p class="etiqueta">Pacientes activos</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="tarjeta-contador">
                    <p class="numero"><?php echo $contadores['total_medicos'] ?? 0; ?></p>
                    <p class="etiqueta">Médicos activos</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="tarjeta-contador">
                    <p class="numero"><?php echo $contadores['citas_agendadas'] ?? 0; ?></p>
                    <p class="etiqueta">Citas agendadas</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="tarjeta-contador">
                    <p class="numero"><?php echo $contadores['citas_hoy'] ?? 0; ?></p>
                    <p class="etiqueta">Citas para hoy</p>
                </div>
            </div>
        </div>

        <!-- ultimas citas -->
        <div class="row">
            <div class="col-12">
                <div class="tarjeta-panel">
                    <h5 class="mb-3"><i class="fa fa-list" style="color:#244cb6;"></i> Últimas citas registradas</h5>

                    <?php if (count($ultimas) === 0) { ?>
                        <p>Aún no hay citas registradas en el sistema.</p>
                    <?php } else { ?>
                        <div class="table-responsive">
                            <table class="table tabla-citas">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Paciente</th>
                                        <th>Médico</th>
                                        <th>Especialidad</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ultimas as $cita) { ?>
                                        <tr>
                                            <td><?php echo $cita['fecha']; ?></td>
                                            <td><?php echo substr($cita['hora'], 0, 5); ?></td>
                                            <td><?php echo htmlspecialchars($cita['paciente']); ?></td>
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

                    <a href="../vCitas/GestionCitas.php" class="btn-medisalud-sec" style="display:inline-block; text-decoration:none;">Ir a gestión de citas</a>
                </div>
            </div>
        </div>

    </div>
</main>

<?php
PintarFooter();
ImportJS();
?>
