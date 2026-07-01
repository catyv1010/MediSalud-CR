<?php
// franjas de atencion de un medico (solo administrador)
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/SeguridadController.php';
ValidarSesion(array('administrador'));

include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/CatalogosController.php';

$medicoId = intval($_GET['medico'] ?? 0);
$medico   = MedicoAdminControl($medicoId);
$franjas  = FranjasAdminControl($medicoId);

$titulo_pagina = "Horarios del médico - MediSalud CR";
include_once '../LayoutInterno.php';
ImportCSS($titulo_pagina);
PintarHeader();
?>

<main class="panel-fondo">
    <div class="container">

        <?php PintarMensaje(); ?>

        <?php if ($medico == null) { ?>
            <div class="tarjeta-panel">
                <p>El médico indicado no existe.</p>
                <p><a href="Medicos.php">Volver a la lista de médicos</a></p>
            </div>
        <?php } else { ?>

            <h2 class="mb-1">Horarios de atención</h2>
            <p class="mb-3" style="color:#5a6272;">
                <?php echo htmlspecialchars($medico['nombre']); ?> — <?php echo htmlspecialchars($medico['especialidad']); ?>
            </p>

            <div class="row">
                <div class="col-lg-5">
                    <div class="tarjeta-panel">
                        <h5 class="mb-3">Agregar franja</h5>

                        <form action="../../Controller/CatalogosController.php" method="POST" class="needs-validation" novalidate>
                            <input type="hidden" name="medico_id" value="<?php echo $medico['id']; ?>">
                            <div class="form-group">
                                <label for="dia_semana">Día <span style="color:#c00;">*</span></label>
                                <select class="form-control" name="dia_semana" id="dia_semana" required>
                                    <option value="">Seleccione</option>
                                    <option value="Lunes">Lunes</option>
                                    <option value="Martes">Martes</option>
                                    <option value="Miercoles">Miércoles</option>
                                    <option value="Jueves">Jueves</option>
                                    <option value="Viernes">Viernes</option>
                                    <option value="Sabado">Sábado</option>
                                    <option value="Domingo">Domingo</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="hora_inicio">Desde <span style="color:#c00;">*</span></label>
                                        <input class="form-control" name="hora_inicio" id="hora_inicio" type="time" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="hora_fin">Hasta <span style="color:#c00;">*</span></label>
                                        <input class="form-control" name="hora_fin" id="hora_fin" type="time" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" name="btnAgregarHorario" class="btn-medisalud">Agregar</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="tarjeta-panel">
                        <?php if (count($franjas) == 0) { ?>
                            <p>Este médico aún no tiene franjas de atención.</p>
                        <?php } else { ?>
                            <div class="table-responsive">
                                <table class="table tabla-citas">
                                    <thead>
                                        <tr>
                                            <th>Día</th>
                                            <th>Desde</th>
                                            <th>Hasta</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($franjas as $franja) { ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($franja['dia_semana']); ?></td>
                                                <td><?php echo substr($franja['hora_inicio'], 0, 5); ?></td>
                                                <td><?php echo substr($franja['hora_fin'], 0, 5); ?></td>
                                                <td>
                                                    <form action="../../Controller/CatalogosController.php" method="POST" class="form-eliminar" style="display:inline;">
                                                        <input type="hidden" name="medico_id" value="<?php echo $medico['id']; ?>">
                                                        <input type="hidden" name="horario_id" value="<?php echo $franja['id']; ?>">
                                                        <button type="submit" name="btnEliminarHorario" class="btn-medisalud-sec">Eliminar</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
                        <p><a href="Medicos.php">Volver a la lista de médicos</a></p>
                    </div>
                </div>
            </div>

        <?php } ?>

    </div>
</main>

<?php
PintarFooter();
ImportJS();
?>
