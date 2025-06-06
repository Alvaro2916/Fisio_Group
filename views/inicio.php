<?php
require_once('models/usuariosModel.php');
$model = new usuariosModel();
$fisios = array_filter($model->readAll(), fn($u) => $u->permisos == 1);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Clínica de Fisioterapia</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="/css/inicio.css" />
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  <!-- Hero Section -->
  <header id="inicio" class="hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="container">
      <h1 class="display-4 fw-bold mb-3">Lo importante es su salud</h1>
      <p class="lead mb-4">Comprometidos con tu bienestar integral y recuperación personalizada</p>
      <a href="#especialistas" class="btn btn-lg btn-light text-primary fw-semibold">Conoce a nuestros especialistas</a>
    </div>
  </header>

  <!-- Carrusel de imágenes -->
  <section class="container my-5">
    <div id="carouselFisio" class="carousel slide shadow rounded" data-bs-ride="carousel" data-bs-interval="4000">
      <div class="carousel-inner rounded">
        <div class="carousel-item active">
          <img src="assets/img/fondos/Fondo1.jpg" class="d-block w-100" alt="Alivio del dolor con técnicas avanzadas" />
          <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-2">
            <h5>Alivio del dolor con técnicas avanzadas</h5>
          </div>
        </div>
        <div class="carousel-item">
          <img src="../assets/img/fondos/Fondo2.jpg" class="d-block w-100" alt="Recuperación muscular personalizada" />
          <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-2">
            <h5>Recuperación muscular personalizada</h5>
          </div>
        </div>
        <div class="carousel-item">
          <img src="assets/img/fondos/Fondo3.jpg" class="d-block w-100" alt="Movilidad y bienestar en manos expertas" />
          <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-2">
            <h5>Movilidad y bienestar en manos expertas</h5>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselFisio" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselFisio" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
      </button>
    </div>
  </section>

  <!-- Especialistas -->
  <section id="especialistas" class="container my-5">
    <h2 class="text-center mb-4 fw-bold text-primary">Nuestros Especialistas</h2>
    <div class="row g-4">
      <?php foreach ($fisios as $fisio): ?>
        <article class="col-md-4">
          <div class="card shadow-sm h-100">
            <img src="/img/<?= htmlspecialchars($fisio->imagen) ?>" class="card-img-top" />
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?= htmlspecialchars($fisio->nombre) ?></h5>
              <p class="card-text flex-grow-1"><?= htmlspecialchars($fisio->descripcion) ?></p>
              <a href="index.php?tabla=mensajes&accion=crear" class="btn btn-primary mt-3 align-self-start">Pedir Cita</a>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-4">
      <a href="index.php?tabla=mensajes&accion=miscitas" class="btn btn-outline-primary btn-lg">Ver tu calendario de citas</a>
    </div>
  </section>

  <!-- Quienes somos -->
  <section id="quienes-somos" class="bg-light py-5">
    <div class="container text-center">
      <h2 class="mb-4 fw-bold text-primary">¿Quiénes somos?</h2>
      <p class="lead mx-auto" style="max-width: 700px;">
        En nuestra clínica de fisioterapia priorizamos el bienestar integral de nuestros pacientes.
        Contamos con profesionales altamente cualificados que diseñan planes de recuperación personalizados,
        combinando experiencia y tecnología avanzada para garantizar los mejores resultados.
      </p>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer bg-primary text-white py-4 text-center">
    <div class="container">
      <small>&copy; 2025 Clínica de Fisioterapia. Todos los derechos reservados.</small>
    </div>
  </footer>
</body>
</html>
