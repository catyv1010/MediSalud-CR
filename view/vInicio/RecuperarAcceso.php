<?php
// vista para recuperar la contrasena
$titulo_pagina = "Recuperar acceso - MediSalud CR";
include_once '../LayoutExterno.php';
ImportCSS($titulo_pagina);
PintarHeader();
?>

<main>
    <div class="bradcam-area" style="background:linear-gradient(120deg, #244cb6 0%, #2e75b6 100%); padding:100px 0;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-8 col-md-10 text-center" style="color:white;">
                    <h2 style="color:white;">Recuperar acceso</h2>
                    <p>Le enviaremos un enlace para restablecer su contraseña</p>
                </div>
            </div>
        </div>
    </div>

    <div class="contact-section" style="padding:80px 0; background:#f7faff;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-7 col-md-9">
                    <div class="form-contact" style="background:white; padding:50px 40px; border-radius:8px; box-shadow:0 4px 20px rgba(0,0,0,0.08);">

                        <h3 class="text-center mb-30" style="color:#244cb6;">¿Olvidó su contraseña?</h3>
                        <p class="text-center mb-40" style="color:#666;">
                            Ingrese el correo electrónico asociado a su cuenta y le enviaremos
                            las instrucciones para restablecer su contraseña.
                        </p>

                        <form action="../../control/InicioController.php" method="POST" id="form-recuperar" class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="correo">Correo electrónico <span style="color:#c00;">*</span></label>
                                        <input class="form-control valid" name="correo" id="correo" type="email" placeholder="ejemplo@correo.com" required autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-4 text-center">
                                <button type="submit" name="btnRecuperar" style="width:100%; background:#244cb6; color:#ffffff; border:none; padding:14px 20px; border-radius:6px; font-size:16px; font-weight:bold; cursor:pointer; transition:background 0.2s;" onmouseover="this.style.background='#1a3a8c'" onmouseout="this.style.background='#244cb6'">Enviar enlace de recuperación</button>
                            </div>
                            <div class="text-center mt-4">
                                <p>
                                    <a href="IniciarSesion.php" style="color:#244cb6;">Volver al inicio de sesión</a>
                                </p>
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
