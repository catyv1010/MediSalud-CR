<?php
// gestion de usuarios del sistema (solo administrador)
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/SeguridadController.php';
ValidarSesion(array('administrador'));

include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/CatalogosController.php';

$usuarios = UsuariosAdminControl();

$titulo_pagina = "Usuarios - MediSalud CR";
include_once '../LayoutInterno.php';
ImportCSS($titulo_pagina);
PintarHeader();
?>

<main class="panel-fondo">
    <div class="container">

        <?php PintarMensaje(); ?>

        <h2 class="mb-3">Usuarios del sistema</h2>

        <div class="tarjeta-panel">
            <?php if (count($usuarios) == 0) { ?>
                <p>No hay usuarios registrados.</p>
            <?php } else { ?>
                <div class="table-responsive">
                    <table class="table tabla-citas">
                        <thead>
                            <tr>
                                <th>Cédula</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $usuario) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($usuario['cedula']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
                                    <td>
                                        <span class="badge-estado <?php echo $usuario['activo'] ? 'estado-atendida' : 'estado-cancelada'; ?>">
                                            <?php echo $usuario['activo'] ? 'Activo' : 'Inactivo'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($usuario['id'] != $_SESSION['usuario_id']) { ?>
                                            <form action="../../Controller/CatalogosController.php" method="POST" style="display:inline;">
                                                <input type="hidden" name="usuario_id" value="<?php echo $usuario['id']; ?>">
                                                <input type="hidden" name="activo" value="<?php echo $usuario['activo'] ? 0 : 1; ?>">
                                                <button type="submit" name="btnEstadoUsuario" class="btn-medisalud-sec">
                                                    <?php echo $usuario['activo'] ? 'Desactivar' : 'Activar'; ?>
                                                </button>
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
