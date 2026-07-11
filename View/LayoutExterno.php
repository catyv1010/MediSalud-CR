<?php
// layout de las vistas publicas, aqui va todo lo que se repite
// las rutas son relativas a view/vInicio

// head con los css, abre el body
function ImportCSS($titulo = 'MediSalud CR')
{
    echo '<!DOCTYPE html>
<html class="no-js" lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>' . htmlspecialchars($titulo) . '</title>
    <meta name="description" content="Sistema de agendamiento de citas medicas - Clinica MediSalud CR">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/favicon.ico">

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../../assets/css/slicknav.css">
    <link rel="stylesheet" href="../../assets/css/flaticon.css">
    <link rel="stylesheet" href="../../assets/css/gijgo.css">
    <link rel="stylesheet" href="../../assets/css/animate.min.css">
    <link rel="stylesheet" href="../../assets/css/animated-headline.css">
    <link rel="stylesheet" href="../../assets/css/magnific-popup.css">
    <link rel="stylesheet" href="../../assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../../assets/css/themify-icons.css">
    <link rel="stylesheet" href="../../assets/css/slick.css">
    <link rel="stylesheet" href="../../assets/css/nice-select.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/medisalud.css">
</head>
<body>
';
}

// menu de arriba
function PintarHeader()
{
    echo '
<header>
    <div class="header-area">
        <div class="main-header header-sticky">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-xl-3 col-lg-3 col-md-2">
                        <div class="logo">
                            <a href="Principal.php">
                                <strong style="color:#244cb6; font-size:22px;">MediSalud CR</strong>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-9 col-md-10">
                        <div class="menu-main d-flex align-items-center justify-content-end">
                            <div class="main-menu f-right d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">
                                        <li><a href="Principal.php">Inicio</a></li>
                                        <li><a href="AcercaDe.php">Acerca de</a></li>
                                        <li><a href="Medicos.php">Médicos</a></li>
                                        <li><a href="Especialidades.php">Especialidades</a></li>
                                        <li><a href="IniciarSesion.php">Iniciar sesión</a></li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="header-right-btn f-right d-none d-lg-block ml-30">
                                <a href="RegistrarUsuarios.php" class="btn header-btn">Registrarse</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
';
}

// pie de pagina
function PintarFooter()
{
    echo '
<footer>
    <div class="footer-wrappper section-bg2" data-background="../../assets/img/gallery/section_bg03.png" style="padding:60px 0; background:#1f3864; color:#dfe7f5;">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="footer-tittle mb-50">
                        <h4 style="color:white;">MediSalud CR</h4>
                        <p>Sistema de agendamiento de citas médicas para la Clínica MediSalud CR. Atención de calidad las veinticuatro horas.</p>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="footer-tittle mb-50">
                        <h4 style="color:white;">Contacto</h4>
                        <p>San José, Costa Rica</p>
                        <p>Tel: (506) 8895-0175</p>
                        <p>contacto@medisaludcr.example</p>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="footer-tittle mb-50">
                        <h4 style="color:white;">Enlaces rápidos</h4>
                        <ul class="enlaces-footer" style="list-style:none; padding:0;">
                            <li><a href="IniciarSesion.php">Iniciar sesión</a></li>
                            <li><a href="RegistrarUsuarios.php">Crear cuenta</a></li>
                            <li><a href="RecuperarAcceso.php">Recuperar acceso</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row" style="border-top:1px solid #344b85; padding-top:20px; margin-top:20px;">
                <div class="col-12 text-center">
                    <p>&copy; ' . date('Y') . ' Clínica MediSalud CR — Proyecto académico Grupo 8 — SC-502 Ambiente Web Cliente/Servidor — Universidad Fidélitas</p>
                </div>
            </div>
        </div>
    </div>
</footer>
';
}

// scripts y cierre del html
// $extras: javascripts propios de la vista (ej. las validaciones de su formulario)
function ImportJS($extras = array())
{
    echo '
<!-- scripts -->
<script src="../../assets/js/vendor/modernizr-3.5.0.min.js"></script>
<script src="../../assets/js/vendor/jquery-1.12.4.min.js"></script>
<script src="../../assets/js/popper.min.js"></script>
<script src="../../assets/js/bootstrap.min.js"></script>
<script src="../../assets/js/owl.carousel.min.js"></script>
<script src="../../assets/js/slick.min.js"></script>
<script src="../../assets/js/jquery.slicknav.min.js"></script>
<script src="../../assets/js/jquery.magnific-popup.js"></script>
<script src="../../assets/js/wow.min.js"></script>
<script src="../../assets/js/animated.headline.js"></script>
<script src="../../assets/js/jquery.nice-select.min.js"></script>
<script src="../../assets/js/jquery.validate.min.js"></script>
<script src="../../assets/js/plantilla.js"></script>
';

    foreach ($extras as $script) {
        echo '<script src="' . $script . '"></script>
';
    }

    echo '
</body>
</html>
';
}

// pinta un mensaje de exito o error si viene en la URL (?msj=...&tipo=ok|error)
function PintarMensaje()
{
    if (isset($_GET['msj']) && $_GET['msj'] !== '') {
        $tipo  = (isset($_GET['tipo']) && $_GET['tipo'] === 'ok') ? 'success' : 'danger';
        echo '<div class="alert alert-' . $tipo . ' text-center" role="alert">'
           . htmlspecialchars($_GET['msj'])
           . '</div>';
    }
}
