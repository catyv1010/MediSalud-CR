<?php
// vista de login
$titulo_pagina = "Iniciar sesión - MediSalud CR";
include_once '../LayoutExterno.php';
ImportCSS($titulo_pagina);
PintarHeader();
?>

<main>
    <!-- encabezado -->
    <div class="bradcam-area" style="background:linear-gradient(120deg, #244cb6 0%, #2e75b6 100%); padding:100px 0;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-8 col-md-10 text-center" style="color:white;">
                    <h2 style="color:white;">Iniciar sesión</h2>
                    <p>Acceda a su cuenta para gestionar sus citas médicas</p>
                </div>
            </div>
        </div>
    </div>

    <!-- formulario -->
    <div class="contact-section" style="padding:80px 0; background:#f7faff;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-7 col-md-9">
                    <div class="form-contact" style="background:white; padding:50px 40px; border-radius:8px; box-shadow:0 4px 20px rgba(0,0,0,0.08);">

                        <h3 class="text-center mb-30" style="color:#244cb6;">Bienvenido de nuevo</h3>
                        <p class="text-center mb-40" style="color:#666;">Ingrese sus credenciales para continuar</p>

                        <?php PintarMensaje(); ?>

                        <form action="../../Controller/InicioController.php" method="POST" id="form-login" class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="cedula">Usuario o cédula <span style="color:#c00;">*</span></label>
                                        <input class="form-control valid" name="cedula" id="cedula" type="text" placeholder="admin o número de cédula" required maxlength="20" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="contrasena">Contraseña <span style="color:#c00;">*</span></label>
                                        <input class="form-control valid" name="contrasena" id="contrasena" type="password" placeholder="Ingrese su contraseña" required minlength="5" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <a href="RecuperarAcceso.php" style="color:#244cb6;">¿Olvidó su contraseña?</a>
                                </div>
                            </div>
                            <div class="form-group mt-4 text-center">
                                <button type="submit" name="btnLogin" class="btn-medisalud">Iniciar sesión</button>
                            </div>
                            <div class="text-center mt-4">
                                <p>¿No tiene una cuenta? <a href="RegistrarUsuarios.php" style="color:#244cb6; font-weight:bold;">Regístrese</a></p>
                            </div>
                        </form>

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
