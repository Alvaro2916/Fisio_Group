<?php
require_once('models/usuariosModel.php');
$model = new usuariosModel();
$fisios = array_filter($model->readAll(), fn($u) => $u->permisos == 1);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clínica de Fisioterapia</title>
    <link rel="stylesheet" href="/css/inicio.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS Bundle (con toggler) -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <header class="hero">
        <h1>Lo importante es su salud</h1>
    </header>

    <section class="carrusel">
        <div class="slide">
            <img src="/imagenes/fisio1.jpg" alt="Fisioterapia 1">
            <p>Alivio del dolor con técnicas avanzadas</p>
        </div>
        <div class="slide">
            <img src="/imagenes/fisio2.jpg" alt="Fisioterapia 2">
            <p>Recuperación muscular personalizada</p>
        </div>
        <div class="slide">
            <img src="/imagenes/fisio3.jpg" alt="Fisioterapia 3">
            <p>Movilidad y bienestar en manos expertas</p>
        </div>
    </section>

    <section class="container my-5">
        <div class="row">
            <?php foreach ($fisios as $fisio): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm card-fisio">
                        <img src="/imagenes/<?= htmlspecialchars($fisio->imagen) ?>" class="card-img-top" alt="<?= htmlspecialchars($fisio->nombre) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($fisio->nombre) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($fisio->descripcion) ?></p>
                            <a href="index.php?tabla=usuarios&accion=mensaje&id=<?= $fisio->id ?>" class="btn btn-primary">Pedir Cita</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="quienes">
        <h2>¿Quiénes somos?</h2>
        <p>En nuestra clínica de fisioterapia priorizamos el bienestar integral. Contamos con profesionales altamente cualificados que trabajan contigo para diseñar el mejor plan de recuperación.</p>
    </section>

    <footer class="footer">
        <p>&copy; 2025 Clínica de Fisioterapia. Todos los derechos reservados.</p>
    </footer>

</body>
</html>
