<?php
// datos personales del usuario con sesion iniciada
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/SeguridadController.php';
ValidarSesion();

include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/UsuariosController.php';

// se consultan los datos actuales para precargar el formulario
$usuario = PerfilControl();

$titulo_pagina = "Mi perfil - MediSalud CR";
include_once '../LayoutInterno.php';
ImportCSS($titulo_pagina);
PintarHeader();
?>

<main class="panel-fondo">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-7 col-md-9">
                <div class="tarjeta-panel">

                    <h3 class="text-center mb-4">Mi perfil</h3>
                    <p class="text-center">Actualice su información personal para mantener su cuenta al día.</p>

                    <?php PintarMensaje(); ?>

                    <form action="../../Controller/UsuariosController.php" method="POST" id="form-perfil">
                        <div class="form-group">
                            <label for="cedula">Cédula <span style="color:#c00;">*</span></label>
                            <input class="form-control" name="cedula" id="cedula" type="text" value="<?php echo htmlspecialchars($usuario['cedula'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="nombre">Nombre completo <span style="color:#c00;">*</span></label>
                            <input class="form-control" name="nombre" id="nombre" type="text" value="<?php echo htmlspecialchars($usuario['nombre'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="correo">Correo electrónico <span style="color:#c00;">*</span></label>
                            <input class="form-control" name="correo" id="correo" type="text" value="<?php echo htmlspecialchars($usuario['correo'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input class="form-control" name="telefono" id="telefono" type="text" value="<?php echo htmlspecialchars($usuario['telefono'] ?? ''); ?>">
                        </div>
                        <div class="form-group mt-4 text-center">
                            <button type="submit" name="btnCambiarPerfil" class="btn-medisalud">Procesar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</main>

<?php
PintarFooter();
ImportJS(array('../../assets/js/nombresapi.js', '../../assets/js/miperfil.js'));
?>
