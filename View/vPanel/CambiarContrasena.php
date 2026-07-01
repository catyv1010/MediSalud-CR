<?php
// cambio de contrasena para cualquier usuario con sesion iniciada
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/SeguridadController.php';
ValidarSesion();

$titulo_pagina = "Cambiar contraseña - MediSalud CR";
include_once '../LayoutInterno.php';
ImportCSS($titulo_pagina);
PintarHeader();
?>

<main class="panel-fondo">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-7 col-md-9">
                <div class="tarjeta-panel">

                    <h3 class="text-center mb-4">Cambiar contraseña</h3>

                    <?php PintarMensaje(); ?>

                    <form action="../../Controller/InicioController.php" method="POST" id="form-cambiar" class="needs-validation" novalidate>
                        <div class="form-group">
                            <label for="contrasena_actual">Contraseña actual <span style="color:#c00;">*</span></label>
                            <input class="form-control" name="contrasena_actual" id="contrasena_actual" type="password" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="contrasena">Contraseña nueva <span style="color:#c00;">*</span></label>
                            <input class="form-control" name="contrasena_nueva" id="contrasena" type="password" placeholder="Mínimo 6 caracteres" required minlength="6">
                        </div>
                        <div class="form-group">
                            <label for="contrasena_confirmar">Confirmar contraseña nueva <span style="color:#c00;">*</span></label>
                            <input class="form-control" name="contrasena_confirmar" id="contrasena_confirmar" type="password" placeholder="Repita la contraseña nueva" required minlength="6">
                        </div>
                        <div class="form-group mt-4 text-center">
                            <button type="submit" name="btnCambiarContrasena" class="btn-medisalud">Actualizar contraseña</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</main>

<?php
PintarFooter();
ImportJS();
?>
