<?php
require_once "controllers/usuariosController.php";
$controlador = new UsuariosController();
$fisios = $controlador->listar();
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

  <header id="inicio" class="hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="container">
      <h1 class="display-4 fw-bold mb-3">Lo importante es su salud</h1>
      <p class="lead mb-4">Comprometidos con tu bienestar integral y recuperación personalizada</p>

      <div class="mb-3">
        <a href="index.php?tabla=mensajes&accion=miscitas" class="btn btn-light fw-semibold">Ver tu calendario de citas</a>
      </div>
    </div>
  </header>

  <!-- Carrusel de imágenes -->
  <section class="container my-5">
    <div id="carouselFisio" class="carousel slide shadow-lg rounded overflow-hidden" data-bs-ride="carousel" data-bs-interval="4000">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="assets/img/Fondos/Fondo3.webp" class="d-block w-100" style="object-fit: cover; height: 500px;" alt="Alivio del dolor con técnicas avanzadas" />
          <div class="carousel-caption d-block bg-dark bg-opacity-75 rounded p-3">
            <h5 class="fw-bold">Alivio del dolor con técnicas avanzadas</h5>
            <p>Tratamientos personalizados para mejorar tu calidad de vida</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="assets/img/Fondos/Fondo4.webp" class="d-block w-100" style="object-fit: cover; height: 500px;" alt="Recuperación muscular personalizada" />
          <div class="carousel-caption d-block bg-dark bg-opacity-75 rounded p-3">
            <h5 class="fw-bold">Recuperación muscular personalizada</h5>
            <p>Planes diseñados por especialistas para cada necesidad</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="assets/img/Fondos/Fondo5.webp" class="d-block w-100" style="object-fit: cover; height: 500px;" alt="Movilidad y bienestar en manos expertas" />
          <div class="carousel-caption d-block bg-dark bg-opacity-75 rounded p-3">
            <h5 class="fw-bold">Movilidad y bienestar en manos expertas</h5>
            <p>Mejora tu día a día con nuestras terapias especializadas</p>
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
        <?php if($fisio->permisos == 1) { ?>
          <article class="col-md-4">
            <div class="card shadow-sm h-100">
              <img src="assets/img/usuarios/<?= $fisio->nombre."/".urlencode($fisio->imagen) ?>" width="100px" class="card-img-top"><br>
              <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?= $fisio->nombre ?></h5>
                <p class="card-text flex-grow-1"><?= $fisio->descripcion ?></p>
                <a href="index.php?tabla=mensajes&accion=crear" class="btn btn-primary mt-3 align-self-start">Pedir Cita</a>
              </div>
            </div>
          </article>
        <?php }; ?>  
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Dolores comunes -->
  <section id="dolores" class="container my-5">
    <h2 class="text-center mb-4 fw-bold text-danger">Dolores Comunes</h2>
    <p class="text-center mb-4" style="max-width: 700px; margin: 0 auto;">
      El dolor es una señal de alerta que no debemos ignorar. Aquí te mostramos los más frecuentes que tratamos:
    </p>
    <div class="row g-4 text-center">
      <div class="col-md-4">
        <a href="index.php?tabla=mensajes&accion=dolor" class="text-decoration-none text-dark">
          <img src="assets/img/Fondos/espalda.jpg" class="img-fluid rounded shadow" alt="Dolor de espalda" />
          <h5 class="mt-2">Dolor de espalda</h5>
        </a>
      </div>
      <div class="col-md-4">
        <a href="index.php?tabla=mensajes&accion=dolor" class="text-decoration-none text-dark">
          <img src="assets/img/Fondos/cuello.jpg" class="img-fluid rounded shadow" alt="Dolor de cuello" />
          <h5 class="mt-2">Dolor de cuello</h5>
        </a>
      </div>
      <div class="col-md-4">
        <a href="index.php?tabla=mensajes&accion=dolor" class="text-decoration-none text-dark">
          <img src="assets/img/Fondos/articu.jpeg" class="img-fluid rounded shadow" alt="Dolores articulares" />
          <h5 class="mt-2">Dolores articulares</h5>
        </a>
      </div>
    </div>
  </section>

  <!-- Ubicación -->
  <section id="ubicacion" class="container my-5">
    <h2 class="text-center mb-4 fw-bold text-success">Dónde estamos</h2>
    <p class="text-center mb-4">Puedes visitarnos en: <strong>Calle Virgen de Fátima Nº65, Aspe</strong></p>
    <div class="ratio ratio-16x9 shadow rounded">
      <iframe
        src="https://www.google.com/maps?q=Calle+Virgen+de+Fátima+65,+Aspe&output=embed"
        allowfullscreen
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
      ></iframe>
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
  <footer class="footer text-white text-center">
    <div class="container">
      <div class="mb-3">
        <a href="#"><img src="assets/img/Fondos/face.webp" alt="Facebook"></a>
        <a href="#"><img src="assets/img/Fondos/insta.jpg" alt="Instagram"></a>
        <a href="#"><img src="assets/img/Fondos/x.webp" alt="X"></a>
      </div>
      <small>&copy; 2025 Clínica de Fisioterapia. Todos los derechos reservados.</small>
      <div class="footer-links mt-2">
        <a href="privacidad.php">Política de Privacidad</a> |
        <a href="cookies.php">Política de Cookies</a> |
        <a href="aviso-legal.php">Aviso Legal</a>
      </div>
    </div>
  </footer>
</body>
</html>
