<?php
// catalogo de especialidades (solo administrador)
// para editar se usa ?editar=id y el formulario de arriba se llena con esos datos
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/SeguridadController.php';
ValidarSesion(array('administrador'));

include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/CatalogosController.php';

$especialidades = EspecialidadesAdminControl();

// si viene ?editar=id se precargan los datos en el formulario
$editando = null;
if (isset($_GET['editar'])) {
    foreach ($especialidades as $esp) {
        if ($esp['id'] == intval($_GET['editar'])) {
            $editando = $esp;
        }
    }
}

$titulo_pagina = "Especialidades - MediSalud CR";
include_once '../LayoutInterno.php';
ImportCSS($titulo_pagina);
PintarHeader();
?>

<main class="panel-fondo">
    <div class="container">

        <?php PintarMensaje(); ?>

        <h2 class="mb-3">Especialidades</h2>

        <div class="row">
            <div class="col-lg-5">
                <div class="tarjeta-panel">
                    <h5 class="mb-3"><?php echo ($editando == null) ? 'Nueva especialidad' : 'Editar especialidad'; ?></h5>

                    <form action="../../Controller/CatalogosController.php" method="POST" class="needs-validation" novalidate>
                        <?php if ($editando != null) { ?>
                            <input type="hidden" name="id" value="<?php echo $editando['id']; ?>">
                        <?php } ?>
                        <div class="form-group">
                            <label for="nombre">Nombre <span style="color:#c00;">*</span></label>
                            <input class="form-control" name="nombre" id="nombre" type="text" required maxlength="100"
                                value="<?php echo ($editando != null) ? htmlspecialchars($editando['nombre']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" rows="3" maxlength="500"><?php echo ($editando != null) ? htmlspecialchars($editando['descripcion'] ?? '') : ''; ?></textarea>
                        </div>
                        <div class="form-group text-center">
                            <?php if ($editando == null) { ?>
                                <button type="submit" name="btnCrearEspecialidad" class="btn-medisalud">Guardar</button>
                            <?php } else { ?>
                                <button type="submit" name="btnActualizarEspecialidad" class="btn-medisalud">Actualizar</button>
                                <p class="mt-2"><a href="Especialidades.php">Cancelar edición</a></p>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="tarjeta-panel">
                    <?php if (count($especialidades) == 0) { ?>
                        <p>No hay especialidades registradas.</p>
                    <?php } else { ?>
                        <div class="table-responsive">
                            <table class="table tabla-citas">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($especialidades as $esp) { ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($esp['nombre']); ?></td>
                                            <td><?php echo htmlspecialchars($esp['descripcion'] ?? ''); ?></td>
                                            <td style="white-space:nowrap;">
                                                <a href="Especialidades.php?editar=<?php echo $esp['id']; ?>" class="btn-medisalud-sec" style="text-decoration:none;">Editar</a>
                                                <form action="../../Controller/CatalogosController.php" method="POST" class="form-eliminar" style="display:inline;">
                                                    <input type="hidden" name="id" value="<?php echo $esp['id']; ?>">
                                                    <button type="submit" name="btnEliminarEspecialidad" class="btn-medisalud-sec">Eliminar</button>
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
