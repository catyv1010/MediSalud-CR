<?php
// vista del paciente para agendar una cita
// los selects de medico y hora se llenan por AJAX (citas.js)
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/SeguridadController.php';
ValidarSesion(array('paciente'));

include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/CitasController.php';

$especialidades = EspecialidadesControl();

$titulo_pagina = "Agendar cita - MediSalud CR";
include_once '../LayoutInterno.php';
ImportCSS($titulo_pagina);
PintarHeader();
?>

<main class="panel-fondo">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-8 col-md-10">
                <div class="tarjeta-panel">

                    <h3 class="text-center mb-2">Agendar una cita</h3>
                    <p class="text-center mb-4" style="color:#5a6272;">Seleccione la especialidad, el médico y el horario disponible</p>

                    <?php PintarMensaje(); ?>

                    <form action="../../Controller/CitasController.php" method="POST" id="form-agendar" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="especialidad">Especialidad <span style="color:#c00;">*</span></label>
                                    <select class="form-control" name="especialidad" id="especialidad" required>
                                        <option value="">Seleccione la especialidad</option>
                                        <?php foreach ($especialidades as $especialidad) { ?>
                                            <option value="<?php echo $especialidad['id']; ?>">
                                                <?php echo htmlspecialchars($especialidad['nombre']); ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="medico">Médico <span style="color:#c00;">*</span></label>
                                    <select class="form-control" name="medico" id="medico" required>
                                        <option value="">Seleccione una especialidad primero</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha">Fecha <span style="color:#c00;">*</span></label>
                                    <input class="form-control" name="fecha" id="fecha" type="date" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hora">Hora <span style="color:#c00;">*</span></label>
                                    <select class="form-control" name="hora" id="hora" required>
                                        <option value="">Seleccione médico y fecha</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="motivo">Motivo de la consulta</label>
                                    <textarea class="form-control" name="motivo" id="motivo" rows="3" maxlength="500"
                                        placeholder="Describa brevemente el motivo de su consulta"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3 text-center">
                            <button type="submit" name="btnAgendar" class="btn-medisalud">Agendar cita</button>
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
