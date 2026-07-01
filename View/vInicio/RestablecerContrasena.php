<?php
// vista publica a la que llega el enlace del correo de recuperacion
// valida el token antes de mostrar el formulario de contrasena nueva
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Model/UsuariosModel.php';

$token = $_GET['token'] ?? '';
$datosToken = ($token !== '') ? ValidarTokenModel($token) : null;

$titulo_pagina = "Restablecer contraseña - MediSalud CR";
include_once '../LayoutExterno.php';
ImportCSS($titulo_pagina);
PintarHeader();
?>

<main>
    <div class="bradcam-area" style="background:linear-gradient(120deg, #244cb6 0%, #2e75b6 100%); padding:100px 0;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-8 col-md-10 text-center" style="color:white;">
                    <h2 style="color:white;">Restablecer contraseña</h2>
                    <p>Defina la contraseña nueva de su cuenta</p>
                </div>
            </div>
        </div>
    </div>

    <div class="contact-section" style="padding:80px 0; background:#f7faff;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-7 col-md-9">
                    <div class="form-contact" style="background:white; padding:50px 40px; border-radius:8px; box-shadow:0 4px 20px rgba(0,0,0,0.08);">

                        <?php PintarMensaje(); ?>

                        <?php if ($datosToken === null) { ?>

                            <!-- token invalido, usado o vencido -->
                            <div class="text-center">
                                <i class="fa fa-exclamation-triangle fa-2x mb-3" style="color:#b02a2a;"></i>
                                <h4>El enlace no es válido</h4>
                                <p>El enlace de recuperación ya fue utilizado o expiró (dura 30 minutos).</p>
                                <p><a href="RecuperarAcceso.php" style="color:#244cb6; font-weight:bold;">Solicitar un enlace nuevo</a></p>
                            </div>

                        <?php } else { ?>

                            <h3 class="text-center mb-30" style="color:#244cb6;">Hola, <?php echo htmlspecialchars($datosToken['nombre']); ?></h3>
                            <p class="text-center mb-40">Ingrese su contraseña nueva.</p>

                            <form action="../../Controller/InicioController.php" method="POST" id="form-restablecer" class="needs-validation" novalidate>
                                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="contrasena">Contraseña nueva <span style="color:#c00;">*</span></label>
                                            <input class="form-control" name="contrasena" id="contrasena" type="password" placeholder="Mínimo 6 caracteres" required minlength="6">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="contrasena_confirmar">Confirmar contraseña <span style="color:#c00;">*</span></label>
                                            <input class="form-control" name="contrasena_confirmar" id="contrasena_confirmar" type="password" placeholder="Repita la contraseña" required minlength="6">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-4 text-center">
                                    <button type="submit" name="btnRestablecer" class="btn-medisalud">Guardar contraseña nueva</button>
                                </div>
                            </form>

                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
PintarFooter();
ImportJS();
?>
