<?php
// vista de registro de pacientes
$titulo_pagina = "Crear cuenta - MediSalud CR";
include_once '../LayoutExterno.php';
ImportCSS($titulo_pagina);
PintarHeader();
?>

<main>
    <div class="bradcam-area" style="background:linear-gradient(120deg, #244cb6 0%, #2e75b6 100%); padding:100px 0;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-8 col-md-10 text-center" style="color:white;">
                    <h2 style="color:white;">Crear cuenta</h2>
                    <p>Regístrese como paciente para agendar citas en línea</p>
                </div>
            </div>
        </div>
    </div>

    <div class="contact-section" style="padding:80px 0; background:#f7faff;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10">
                    <div class="form-contact" style="background:white; padding:50px 40px; border-radius:8px; box-shadow:0 4px 20px rgba(0,0,0,0.08);">

                        <h3 class="text-center mb-30" style="color:#244cb6;">Registro de paciente</h3>
                        <p class="text-center mb-40" style="color:#666;">Complete los siguientes datos para crear su cuenta</p>

                        <?php PintarMensaje(); ?>

                        <form action="../../Controller/InicioController.php" method="POST" id="form-registro">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="cedula">Cédula <span style="color:#c00;">*</span></label>
                                        <input class="form-control" name="cedula" id="cedula" type="text" placeholder="Solo números, sin guiones" required maxlength="20" pattern="[0-9]+">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="nombre">Nombre completo <span style="color:#c00;">*</span></label>
                                        <input class="form-control" name="nombre" id="nombre" type="text" placeholder="Se completa automáticamente al ingresar la cédula" required maxlength="150">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="correo">Correo electrónico <span style="color:#c00;">*</span></label>
                                        <input class="form-control" name="correo" id="correo" type="email" placeholder="ejemplo@correo.com" required maxlength="150">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telefono">Teléfono</label>
                                        <input class="form-control" name="telefono" id="telefono" type="tel" placeholder="(506) 0000-0000" maxlength="20">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha_nacimiento">Fecha de nacimiento</label>
                                        <input class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" type="date">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="genero">Género</label>
                                        <select class="form-control" name="genero" id="genero">
                                            <option value="">Seleccione</option>
                                            <option value="F">Femenino</option>
                                            <option value="M">Masculino</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="direccion">Dirección</label>
                                        <input class="form-control" name="direccion" id="direccion" type="text" placeholder="Provincia, cantón, distrito" maxlength="255">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contrasena">Contraseña <span style="color:#c00;">*</span></label>
                                        <input class="form-control" name="contrasena" id="contrasena" type="password" placeholder="Mínimo 6 caracteres" required minlength="6">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contrasena_confirmar">Confirmar contraseña <span style="color:#c00;">*</span></label>
                                        <input class="form-control" name="contrasena_confirmar" id="contrasena_confirmar" type="password" placeholder="Repita la contraseña" required minlength="6">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-4 text-center">
                                <button type="submit" name="btnRegistrar" class="btn-medisalud">Crear cuenta</button>
                            </div>
                            <div class="text-center mt-4">
                                <p>¿Ya tiene una cuenta? <a href="IniciarSesion.php" style="color:#244cb6; font-weight:bold;">Inicie sesión</a></p>
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
ImportJS(array('../../assets/js/nombresapi.js', '../../assets/js/registrarusuarios.js'));
?>
