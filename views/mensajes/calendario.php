<?php
require_once "controllers/mensajesController.php";

if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']->id)) {
    echo "Error: Debes iniciar sesión.";
    exit;
}

$id_fisio = $_SESSION['usuario']->id;
$model = new MensajesModel();
$controller = new MensajesController($model);
$citas = $controller->verCalendario($id_fisio);

$citasPorDia = [];
foreach ($citas as $cita) {
    $fecha = $cita['fecha_cita'];
    $dia = (int)date('d', strtotime($fecha));
    if (!isset($citasPorDia[$dia])) $citasPorDia[$dia] = [];
    $citasPorDia[$dia][] = $cita;
}

// ------------------
// Parámetros del calendario
// ------------------
$anio = date('Y');
$mes = date('m');
$nombreMes = date('F', strtotime("$anio-$mes-01"));
$primerDiaSemana = date('N', strtotime("$anio-$mes-01"));
$diasEnMes = date('t', strtotime("$anio-$mes-01"));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calendario mensual de citas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h1 class="text-center mb-4">Citas de <?= htmlspecialchars($_SESSION['usuario']->nombre) ?> – <?= $nombreMes . " " . $anio ?></h1>

    <table class="table table-bordered">
        <thead class="table-primary">
            <tr>
                <th>Lun</th>
                <th>Mar</th>
                <th>Mié</th>
                <th>Jue</th>
                <th>Vie</th>
                <th>Sáb</th>
                <th>Dom</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $dia = 1;
            for ($fila = 0; $fila < 6; $fila++) {
                echo "<tr>";
                for ($col = 1; $col <= 7; $col++) {
                    if ($fila === 0 && $col < $primerDiaSemana) {
                        echo "<td></td>";
                    } elseif ($dia > $diasEnMes) {
                        echo "<td></td>";
                    } else {
                        echo "<td>";
                        echo "<div class='dia-numero'>$dia</div>";

                        if (isset($citasPorDia[$dia])) {
                            foreach ($citasPorDia[$dia] as $cita) {
                                echo "<div class='cita'>";
                                echo "<strong>" . $cita['nombre_cliente'] . ":</strong> " . $cita['titulo_cita'] . "<br>";
                                echo "<small>" . date('d/m/Y', strtotime($cita['fecha_cita'])) . "</small>";
                                echo "</div>";
                            }
                        }

                        echo "</td>";
                        $dia++;
                    }
                }
                echo "</tr>";
                if ($dia > $diasEnMes) break;
            }
            ?>
        </tbody>
    </table>

    <a class="btn btn-danger" href="index.php?tabla=usuarios&accion=administrar&id=<?= $_SESSION["usuario"]->nombre ?>"><i class="fa-solid fas fa-ban"></i> Volver</a>

</body>
</html>
