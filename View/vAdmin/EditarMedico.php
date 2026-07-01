<?php
// edicion de un medico (solo administrador)
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/SeguridadController.php';
ValidarSesion(array('administrador'));

include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/CatalogosController.php';

$medico = MedicoAdminControl(intval($_GET['id'] ?? 0));
$especialidades = EspecialidadesAdminControl();

$titulo_pagina = "Editar médico - MediSalud CR";
include_once '../LayoutInterno.php';
ImportCSS($titulo_pagina);
PintarHeader();
?>

<main class="panel-fondo">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-7 col-md-9">
                <div class="tarjeta-panel">

                    <?php PintarMensaje(); ?>

                    <?php if ($medico == null) { ?>
                        <p>El médico indicado no existe.</p>
                        <p><a href="Medicos.php">Volver a la lista de médicos</a></p>
                    <?php } else { ?>

                        <h3 class="text-center mb-2">Editar médico</h3>
                        <p class="text-center mb-4" style="color:#5a6272;">
                            Cédula <?php echo htmlspecialchars($medico['cedula']); ?> — <?php echo htmlspecialchars($medico['correo']); ?>
                        </p>

                        <form action="../../Controller/CatalogosController.php" method="POST" class="needs-validation" novalidate>
                            <input type="hidden" name="medico_id" value="<?php echo $medico['id']; ?>">
                            <div class="form-group">
                                <label for="nombre">Nombre completo <span style="color:#c00;">*</span></label>
                                <input class="form-control" name="nombre" id="nombre" type="text" required maxlength="150"
                                    value="<?php echo htmlspecialchars($medico['nombre']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input class="form-control" name="telefono" id="telefono" type="tel" maxlength="20"
                                    value="<?php echo htmlspecialchars($medico['telefono'] ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label for="especialidad">Especialidad <span style="color:#c00;">*</span></label>
                                <select class="form-control" name="especialidad" id="especialidad" required>
                                    <?php foreach ($especialidades as $esp) { ?>
                                        <option value="<?php echo $esp['id']; ?>" <?php echo ($esp['id'] == $medico['especialidad_id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($esp['nombre']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="colegiado">Número de colegiado <span style="color:#c00;">*</span></label>
                                <input class="form-control" name="colegiado" id="colegiado" type="text" required maxlength="50"
                                    value="<?php echo htmlspecialchars($medico['numero_colegiado']); ?>">
                            </div>
                            <div class="form-group mt-4 text-center">
                                <button type="submit" name="btnActualizarMedico" class="btn-medisalud">Guardar cambios</button>
                                <p class="mt-3"><a href="Medicos.php">Volver a la lista</a></p>
                            </div>
                        </form>

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
