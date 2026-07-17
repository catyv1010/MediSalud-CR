<?php
// pagina acerca de la clinica
$titulo_pagina = "Acerca de - MediSalud CR";
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
                    <h2 style="color:white;">Acerca de la Clínica MediSalud CR</h2>
                    <p>Conozca nuestra historia, misión y compromiso con la salud costarricense</p>
                </div>
            </div>
        </div>
    </div>

    <!-- quienes somos -->
    <section style="padding:80px 0; background:#ffffff;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h3 style="color:#244cb6; margin-bottom:25px;">¿Quiénes somos?</h3>
                    <p style="color:#555; line-height:1.8; text-align:justify;">
                        La <strong>Clínica MediSalud CR</strong> es una clínica privada ubicada en
                        San José, Costa Rica. Atiende pacientes en consulta ambulatoria con
                        agendamiento de citas a través del sistema web.
                    </p>
                    <p style="color:#555; line-height:1.8; text-align:justify;">
                        La idea de tener el sistema en línea es que los pacientes puedan reservar
                        sus citas sin tener que llamar por teléfono ni ir hasta la clínica, a
                        cualquier hora del día.
                    </p>
                </div>
                <div class="col-lg-6">
                    <div style="background:#f7faff; border-radius:8px; padding:40px; text-align:center;">
                        <i class="flaticon-hospital" style="font-size:120px; color:#244cb6;"></i>
                        <h4 style="margin-top:20px; color:#244cb6;">MediSalud CR</h4>
                        <p style="color:#777;">San José, Costa Rica</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- mision vision valores -->
    <section style="padding:60px 0; background:#f7faff;">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div style="background:white; padding:42px 32px; border-radius:14px; box-shadow:0 6px 24px rgba(31,44,77,0.08); height:100%;">
                        <div style="width:78px; height:78px; background:#244cb6; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:22px;">
                            <i class="fa fa-bullseye" style="color:white; font-size:32px;"></i>
                        </div>
                        <h4 style="color:#244cb6; font-size:26px; margin-bottom:14px;">Misión</h4>
                        <p style="color:#666; line-height:1.7; text-align:justify;">
                            Brindar atención médica oportuna y de calidad mediante el uso de tecnología
                            que facilite el acceso a citas, reduzca los tiempos de espera y mejore la
                            experiencia tanto del paciente como del personal de salud.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div style="background:white; padding:42px 32px; border-radius:14px; box-shadow:0 6px 24px rgba(31,44,77,0.08); height:100%;">
                        <div style="width:78px; height:78px; background:#2e75b6; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:22px;">
                            <i class="fa fa-eye" style="color:white; font-size:32px;"></i>
                        </div>
                        <h4 style="color:#2e75b6; font-size:26px; margin-bottom:14px;">Visión</h4>
                        <p style="color:#666; line-height:1.7; text-align:justify;">
                            Consolidarnos como una clínica de referencia en Costa Rica por la calidad
                            del servicio y la innovación tecnológica, integrando especialidades, expediente
                            digital y atención centrada en el paciente.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div style="background:white; padding:42px 32px; border-radius:14px; box-shadow:0 6px 24px rgba(31,44,77,0.08); height:100%;">
                        <div style="width:78px; height:78px; background:#70ad47; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:22px;">
                            <i class="fa fa-heart" style="color:white; font-size:32px;"></i>
                        </div>
                        <h4 style="color:#70ad47; font-size:26px; margin-bottom:14px;">Valores</h4>
                        <p style="color:#666; line-height:1.7; text-align:justify;">
                            Compromiso con el paciente, calidad humana, respeto, confidencialidad de la
                            información clínica, trabajo en equipo y mejora continua de los procesos
                            internos.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- stats -->
    <section style="padding:70px 0; background:linear-gradient(120deg, #244cb6 0%, #2e75b6 100%); color:white;">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-4">
                    <h2 style="color:white; font-size:48px;">7</h2>
                    <p>Especialidades</p>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <h2 style="color:white; font-size:48px;">15+</h2>
                    <p>Médicos colegiados</p>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <h2 style="color:white; font-size:48px;">24/7</h2>
                    <p>Agendamiento en línea</p>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <h2 style="color:white; font-size:48px;">100%</h2>
                    <p>Caso académico</p>
                </div>
            </div>
        </div>
    </section>

    <!-- aviso academico -->
    <section style="padding:50px 0; background:#fff;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div style="background:#fff8e1; border-left:4px solid #ffb300; padding:20px 28px; border-radius:4px;">
                        <p style="margin:0; color:#5d4037;">
                            <strong>Nota:</strong> la Clínica MediSalud CR es ficticia, la usamos
                            como caso de estudio para el proyecto del curso SC-502 en la Universidad
                            Fidélitas. Cualquier parecido con una clínica real es coincidencia.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
PintarFooter();
ImportJS();
?>
