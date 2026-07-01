<?php
// reporte mensual de citas por medico y especialidad (solo administrador)
include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/SeguridadController.php';
ValidarSesion(array('administrador'));

include_once $_SERVER['DOCUMENT_ROOT'] . '/MediSalud-CR/Controller/CitasController.php';

// mes y anio consultados (por defecto el mes actual)
$mes  = intval($_GET['mes']  ?? date('n'));
$anio = intval($_GET['anio'] ?? date('Y'));
if ($mes < 1 || $mes > 12) { $mes = intval(date('n')); }

$reporte = ReporteMensualControl($mes, $anio);

$nombresMes = array(1=>'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre');

// totales de la ultima fila
$totCitas = 0; $totAtendidas = 0; $totCanceladas = 0; $totNoAsistio = 0;
foreach ($reporte as $fila) {
    $totCitas      = $totCitas      + $fila['total_citas'];
    $totAtendidas  = $totAtendidas  + $fila['atendidas'];
    $totCanceladas = $totCanceladas + $fila['canceladas'];
    $totNoAsistio  = $totNoAsistio  + $fila['no_asistio'];
}

$titulo_pagina = "Reportes - MediSalud CR";
include_once '../LayoutInterno.php';
ImportCSS($titulo_pagina);
PintarHeader();
?>

<main class="panel-fondo">
    <div class="container">

        <?php PintarMensaje(); ?>

        <h2 class="mb-3">Reporte mensual de citas</h2>

        <div class="tarjeta-panel">
            <!-- filtro de mes y anio, viaja por GET -->
            <form action="Reportes.php" method="GET" class="form-inline mb-3">
                <label for="mes" class="mr-2">Mes</label>
                <select class="form-control mr-3" name="mes" id="mes">
                    <?php foreach ($nombresMes as $numero => $nombre) { ?>
                        <option value="<?php echo $numero; ?>" <?php echo ($numero == $mes) ? 'selected' : ''; ?>>
                            <?php echo $nombre; ?>
                        </option>
                    <?php } ?>
                </select>
                <label for="anio" class="mr-2">Año</label>
                <select class="form-control mr-3" name="anio" id="anio">
                    <?php for ($a = 2026; $a <= intval(date('Y')) + 1; $a++) { ?>
                        <option value="<?php echo $a; ?>" <?php echo ($a == $anio) ? 'selected' : ''; ?>><?php echo $a; ?></option>
                    <?php } ?>
                </select>
                <button type="submit" class="btn-medisalud" style="width:auto; padding:8px 25px;">Consultar</button>
            </form>

            <h5 class="mb-3"><?php echo $nombresMes[$mes] . ' ' . $anio; ?></h5>

            <?php if (count($reporte) == 0) { ?>
                <p>No hay citas registradas en ese mes.</p>
            <?php } else { ?>
                <div class="table-responsive">
                    <table class="table tabla-citas">
                        <thead>
                            <tr>
                                <th>Especialidad</th>
                                <th>Médico</th>
                                <th>Total de citas</th>
                                <th>Atendidas</th>
                                <th>Canceladas</th>
                                <th>No asistió</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reporte as $fila) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($fila['especialidad']); ?></td>
                                    <td><?php echo htmlspecialchars($fila['medico']); ?></td>
                                    <td><?php echo $fila['total_citas']; ?></td>
                                    <td><?php echo $fila['atendidas']; ?></td>
                                    <td><?php echo $fila['canceladas']; ?></td>
                                    <td><?php echo $fila['no_asistio']; ?></td>
                                </tr>
                            <?php } ?>
                            <tr style="font-weight:bold; background:#eef3fd;">
                                <td colspan="2">Totales</td>
                                <td><?php echo $totCitas; ?></td>
                                <td><?php echo $totAtendidas; ?></td>
                                <td><?php echo $totCanceladas; ?></td>
                                <td><?php echo $totNoAsistio; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>

    </div>
</main>

<?php
PintarFooter();
ImportJS();
?>
