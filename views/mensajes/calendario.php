<?php
// Variables para mes y año actual
$anio = date('Y');
$mes = date('m');
$nombreMes = date('F', strtotime("$anio-$mes-01"));
$primerDiaMes = strtotime("$anio-$mes-01");
$diasEnMes = date('t', $primerDiaMes);

// Día de la semana del primer día del mes (1=lunes ... 7=domingo)
$primerDiaSemana = date('N', $primerDiaMes);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calendario de Citas - <?= htmlspecialchars($nombreMes . " " . $anio) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        table {table-layout: fixed;}
        td, th {
            width: 14.28%;
            vertical-align: top;
            height: 120px;
            border: 1px solid #dee2e6;
            padding: 5px;
        }
        .dia-numero {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .cita {
            background-color: #d1e7dd;
            border-radius: 4px;
            padding: 2px 4px;
            margin-bottom: 2px;
            font-size: 0.85em;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5">
    <h1 class="text-center mb-4">Calendario de Citas - <?= htmlspecialchars($nombreMes . " " . $anio) ?></h1>
    <table class="table table-bordered bg-white">
        <thead class="table-primary">
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
            <?php
            $diaActual = 1;
            $terminado = false;

            // Seis filas máximo para cubrir meses largos
            for ($fila = 0; $fila < 6; $fila++) {
                echo "<tr>";

                for ($col = 1; $col <= 7; $col++) {
                    // Primera fila, llenar días vacíos antes del primer día del mes
                    if ($fila === 0 && $col < $primerDiaSemana) {
                        echo "<td></td>";
                    } else if ($diaActual > $diasEnMes) {
                        echo "<td></td>";
                        $terminado = true;
                    } else {
                        echo "<td>";
                        echo "<div class='dia-numero'>{$diaActual}</div>";

                        // Mostrar citas si existen para este día
                        if (isset($citasPorDia[$diaActual])) {
                            foreach ($citasPorDia[$diaActual] as $cita) {
                                echo "<div class='cita' title='" . htmlspecialchars($cita->titulo_cita) . "'>";
                                echo htmlspecialchars($cita->nombre_cliente) . ": " . htmlspecialchars($cita->titulo_cita);
                                echo "</div>";
                            }
                        }

                        echo "</td>";
                        $diaActual++;
                    }
                }

                echo "</tr>";

                if ($terminado) break;
            }
            ?>
        </tbody>
    </table>
    <a href="index.php?tabla=usuarios&accion=administrar&id=<?= $_SESSION["usuario"]->nombre ?>" class="btn btn-secondary">Volver</a>
</div>

</body>
</html>