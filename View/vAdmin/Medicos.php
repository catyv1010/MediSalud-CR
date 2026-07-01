<?php
// catalogo de medicos (solo administrador)
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/SeguridadController.php';
ValidarSesion(array('administrador'));

include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/CatalogosController.php';

$medicos        = MedicosAdminControl();
$especialidades = EspecialidadesAdminControl();

$titulo_pagina = "Médicos - MediSalud CR";
include_once '../LayoutInterno.php';
ImportCSS($titulo_pagina);
PintarHeader();
?>

<main class="panel-fondo">
    <div class="container-fluid" style="max-width:1300px;">

        <?php PintarMensaje(); ?>

        <h2 class="mb-3">Médicos</h2>

        <div class="row">
            <div class="col-lg-4">
                <div class="tarjeta-panel">
                    <h5 class="mb-3">Registrar médico</h5>

                    <form action="../../Controller/CatalogosController.php" method="POST" class="needs-validation" novalidate>
                        <div class="form-group">
                            <label for="cedula">Cédula <span style="color:#c00;">*</span></label>
                            <input class="form-control" name="cedula" id="cedula" type="text" required maxlength="20" pattern="[0-9]+" placeholder="Solo números">
                        </div>
                        <div class="form-group">
                            <label for="nombre">Nombre completo <span style="color:#c00;">*</span></label>
                            <input class="form-control" name="nombre" id="nombre" type="text" required maxlength="150">
                        </div>
                        <div class="form-group">
                            <label for="correo">Correo <span style="color:#c00;">*</span></label>
                            <input class="form-control" name="correo" id="correo" type="email" required maxlength="150">
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input class="form-control" name="telefono" id="telefono" type="tel" maxlength="20">
                        </div>
                        <div class="form-group">
                            <label for="especialidad">Especialidad <span style="color:#c00;">*</span></label>
                            <select class="form-control" name="especialidad" id="especialidad" required>
                                <option value="">Seleccione</option>
                                <?php foreach ($especialidades as $esp) { ?>
                                    <option value="<?php echo $esp['id']; ?>"><?php echo htmlspecialchars($esp['nombre']); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="colegiado">Número de colegiado <span style="color:#c00;">*</span></label>
                            <input class="form-control" name="colegiado" id="colegiado" type="text" required maxlength="50">
                        </div>
                        <div class="form-group">
                            <label for="contrasena">Contraseña temporal <span style="color:#c00;">*</span></label>
                            <input class="form-control" name="contrasena" id="contrasena" type="password" required minlength="6" maxlength="20" placeholder="El médico luego la cambia">
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" name="btnCrearMedico" class="btn-medisalud">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="tarjeta-panel">
                    <?php if (count($medicos) == 0) { ?>
                        <p>No hay médicos registrados.</p>
                    <?php } else { ?>
                        <div class="table-responsive">
                            <table class="table tabla-citas">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Especialidad</th>
                                        <th>Colegiado</th>
                                        <th>Estado</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($medicos as $medico) { ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($medico['nombre']); ?><br>
                                                <small style="color:#5a6272;"><?php echo htmlspecialchars($medico['correo']); ?></small></td>
                                            <td><?php echo htmlspecialchars($medico['especialidad']); ?></td>
                                            <td><?php echo htmlspecialchars($medico['numero_colegiado']); ?></td>
                                            <td>
                                                <span class="badge-estado <?php echo $medico['activo'] ? 'estado-atendida' : 'estado-cancelada'; ?>">
                                                    <?php echo $medico['activo'] ? 'Activo' : 'Inactivo'; ?>
                                                </span>
                                            </td>
                                            <td style="white-space:nowrap;">
                                                <a href="EditarMedico.php?id=<?php echo $medico['id']; ?>" class="btn-medisalud-sec" style="text-decoration:none;">Editar</a>
                                                <a href="HorariosMedico.php?medico=<?php echo $medico['id']; ?>" class="btn-medisalud-sec" style="text-decoration:none;">Horarios</a>
                                                <form action="../../Controller/CatalogosController.php" method="POST" style="display:inline;">
                                                    <input type="hidden" name="usuario_id" value="<?php echo $medico['usuario_id']; ?>">
                                                    <input type="hidden" name="activo" value="<?php echo $medico['activo'] ? 0 : 1; ?>">
                                                    <button type="submit" name="btnEstadoUsuario" class="btn-medisalud-sec">
                                                        <?php echo $medico['activo'] ? 'Desactivar' : 'Activar'; ?>
                                                    </button>
                                                </form>
                                            </td>
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
