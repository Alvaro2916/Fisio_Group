<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <title>Fisio Group </title>
  <!-- Bootstrap core CSS -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Geo:ital@0;1&family=Jersey+15&display=swap" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="assets/css/head.css" rel="stylesheet">
  <link href="assets/css/inicio.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/dolores.css">
  <link href="assets/css/dashboard.css" rel="stylesheet">
  <link href="assets/css/404.css" rel="stylesheet">
  <!-- CSS Mensajes -->
  <link href="assets/css/mensajes/showcita.css" rel="stylesheet">
  <link href="assets/css/mensajes/create.css" rel="stylesheet">
  <link href="assets/css/mensajes/calendarios.css" rel="stylesheet">
</head>

<body  class="fondoPrincipal"> 
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4">
  <div class="imagen-container">
    <img src="assets/img/Logo.png" alt="Logo Principal" class="imagen-principal">
    <a class="navbar-brand" href="index.php">Fisio Group</a>
  </div>
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