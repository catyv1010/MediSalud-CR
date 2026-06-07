<?php
// layout de las vistas con sesion iniciada, se completa en el avance 2
// ojo: una vista incluye este o el externo, no los dos (las funciones se llaman igual)

function ImportCSS($titulo = 'MediSalud CR')
{
    echo '<!DOCTYPE html>
<html class="no-js" lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>' . htmlspecialchars($titulo) . '</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/favicon.ico">
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
';
}

function PintarHeader()
{
    // aqui va el menu del usuario logueado, lo armamos en el avance 2
    echo '
<header>
    <div class="header-area">
        <div class="main-header header-sticky">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="logo">
                            <strong style="color:#244cb6; font-size:22px;">MediSalud CR</strong>
                        </div>
                    </div>
                    <div class="col-6 text-right">
                        <!-- aqui va: nombre del usuario + boton cerrar sesion -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
';
}

function PintarFooter()
{
    echo '
<footer class="text-center" style="padding:20px 0; background:#1f3864; color:#dfe7f5;">
    <p>&copy; ' . date('Y') . ' Clínica MediSalud CR — Grupo 8 — SC-502</p>
</footer>
';
}

function ImportJS()
{
    echo '
<script src="../../assets/js/vendor/jquery-1.12.4.min.js"></script>
<script src="../../assets/js/popper.min.js"></script>
<script src="../../assets/js/bootstrap.min.js"></script>
<script src="../../assets/js/medisalud.js"></script>
</body>
</html>
';
}
