<?php
// calendario mensual de citas de la clinica (solo administrador)
// la cuadricula se arma en php, sin plugins
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/SeguridadController.php';
ValidarSesion(array('administrador'));

include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/CitasController.php';

// mes y anio mostrados (por defecto el mes actual)
$mes  = intval($_GET['mes']  ?? date('n'));
$anio = intval($_GET['anio'] ?? date('Y'));
if ($mes < 1 || $mes > 12) { $mes = intval(date('n')); }

// mes anterior y siguiente para los botones de navegacion
$mesAnterior  = ($mes == 1)  ? 12 : $mes - 1;
$anioAnterior = ($mes == 1)  ? $anio - 1 : $anio;
$mesSiguiente = ($mes == 12) ? 1  : $mes + 1;
$anioSiguiente= ($mes == 12) ? $anio + 1 : $anio;

$nombresMes = array(1=>'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre');

// citas del mes agrupadas por dia
$citasPorDia = CitasDelMesControl($mes, $anio);

// datos para armar la cuadricula
$diasDelMes = intval(date('t', strtotime("$anio-$mes-01")));
$columnaInicio = intval(date('N', strtotime("$anio-$mes-01"))); // 1=lunes ... 7=domingo

$titulo_pagina = "Calendario de citas - MediSalud CR";
include_once '../LayoutInterno.php';
ImportCSS($titulo_pagina);
PintarHeader();
?>

<main class="panel-fondo">
    <div class="container-fluid" style="max-width:1300px;">

        <?php PintarMensaje(); ?>

        <div class="row align-items-center mb-3">
            <div class="col-md-6">
                <h2>Calendario de citas</h2>
            </div>
            <div class="col-md-6 text-md-right">
                <a href="Calendario.php?mes=<?php echo $mesAnterior; ?>&anio=<?php echo $anioAnterior; ?>" class="btn-medisalud-sec" style="text-decoration:none;">&laquo; Anterior</a>
                <strong style="margin:0 15px;"><?php echo $nombresMes[$mes] . ' ' . $anio; ?></strong>
                <a href="Calendario.php?mes=<?php echo $mesSiguiente; ?>&anio=<?php echo $anioSiguiente; ?>" class="btn-medisalud-sec" style="text-decoration:none;">Siguiente &raquo;</a>
            </div>
        </div>

        <div class="tarjeta-panel">
            <div class="table-responsive">
                <table class="table calendario">
                    <thead>
                        <tr>
                            <th>Lunes</th>
                            <th>Martes</th>
                            <th>Miércoles</th>
                            <th>Jueves</th>
                            <th>Viernes</th>
                            <th>Sábado</th>
                            <th>Domingo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <?php
                            // celdas vacias antes del dia 1
                            for ($col = 1; $col < $columnaInicio; $col++) {
                                echo '<td class="dia-vacio"></td>';
                            }

                            for ($dia = 1; $dia <= $diasDelMes; $dia++) {

                                $esHoy = ($dia == intval(date('j')) && $mes == intval(date('n')) && $anio == intval(date('Y')));

                                echo '<td class="' . ($esHoy ? 'dia-hoy' : '') . '">';
                                echo '<div class="numero-dia">' . $dia . '</div>';

                                if (isset($citasPorDia[$dia])) {
                                    foreach ($citasPorDia[$dia] as $cita) {
                                        echo '<div class="cita-cal ' . ClaseEstado($cita['estado']) . '">'
                                           . substr($cita['hora'], 0, 5) . ' '
                                           . htmlspecialchars($cita['medico'])
                                           . '<br><small>' . htmlspecialchars($cita['paciente']) . '</small>'
                                           . '</div>';
                                    }
                                }

                                echo '</td>';

                                // al llegar al domingo se cierra la fila y se abre otra
                                if (($col % 7) == 0 && $dia < $diasDelMes) {
                                    echo '</tr><tr>';
                                }
                                $col++;
                            }

                            // celdas vacias despues del ultimo dia
                            while ((($col - 1) % 7) != 0) {
                                echo '<td class="dia-vacio"></td>';
                                $col++;
                            }
                        ?>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p style="color:#5a6272; font-size:13px; margin-top:8px;">
                <span class="badge-estado estado-agendada">Agendada</span>
                <span class="badge-estado estado-atendida">Atendida</span>
                <span class="badge-estado estado-cancelada">Cancelada</span>
                <span class="badge-estado estado-no-asistio">No asistió</span>
            </p>
        </div>

    </div>
</main>

<?php
PintarFooter();
ImportJS();
?>
