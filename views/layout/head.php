<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <title>Fisio Group </title>
  <link rel="stylesheet" href="/css/inicio.css">
  <!-- Bootstrap core CSS -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Geo:ital@0;1&family=Jersey+15&display=swap" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="assets/css/dashboard.css" rel="stylesheet">
  <link href="assets/css/404.css" rel="stylesheet">
  <link href="assets/css/inventario.css" rel="stylesheet">
  <link href="assets/css/inicio.css" rel="stylesheet">
  <link href="assets/css/digievolucionar.css" rel="stylesheet">
  <link href="assets/css/combatir.css" rel="stylesheet">

  <style>
    
  </style>
</head>

<body  class="fondoPrincipal"> 
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4">
  <div class="imagen-container">
    <img src="/imagenes/fisioterapeuta.jpg" alt="Logo Principal" class="imagen-principal">
    <a class="navbar-brand col-md-3 col-lg-1 me-0 px-3" href="index.php">Fisio Group</a>
  </div>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="nav-item text-nowrap">
    <a> Usuario Conectado: <?= $_SESSION["usuario"]->nombre ?></a>
  </div>
  <div class="collapse navbar-collapse" id="menuFisio">
    <ul class="navbar-nav ms-auto">
      <li class="nav-item">
        <a class="nav-link px-3" href="index.php?tabla=usuarios&accion=editar&id=<?= $_SESSION["usuario"]->id ?>">Editar Perfil</a>
      </li>
      <li class="nav-item">
        <a class="nav-link px-3" href="index.php?tabla=mensajes&accion=ver_cita&id=<?= $_SESSION["usuario"]->id ?>">Ver tus citas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link px-3" href="index.php?tabla=mensajes&accion=crear">Pedir Cita</a>
      </li>
      <?php
      if ($_SESSION["usuario"]->permisos == 1) {
      ?>
        <li class="nav-item">
          <a class="nav-link px-3" href="index.php?tabla=usuarios&accion=administrar&id=<?= $_SESSION["usuario"]->nombre ?>">Administrar</a>
        </li>
      <?php } ?>
      <li class="nav-item">
        <a class="nav-link px-3" href="login.php">Login</a>
      </li>
    </ul>
  </div>
</nav>