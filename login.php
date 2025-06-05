<?php
session_start();
$user = ($_POST["usuario"]) ?? "";
$password = ($_POST["password"]) ?? "";
$error = false;
// aquí no usamos MVC ya que es muy básica la acción
if (isset($_POST["usuario"], $_POST["password"])) {
  //podríamos usar el controlador pero como sólo es hacer una consulta
  require_once "models/usuariosModel.php";
  $userModel = new UsuariosModel();
  $usuario = $userModel->login($user, $password);
  if ($usuario != null) { // Usuario correcto
    $_SESSION["usuario"] = $usuario;
    header("location:index.php");
    exit();
  }
  //SI NO EXISTE EL USUARIO SE HA PRODUCIDO UN ERROR
  $error = true;
}
$msg = "";
$visibilidad = "";
$style = "";
if ($error) {
  $msg = "Error, Usuario o Password Incorrectos";
  $visibilidad = "visible";
  $style = "alert-danger";
}
if (isset($_GET["session"]) && ($_GET["session"] == "logout")) {
  $msg = "Fin de Sesion";
  $visibilidad = "visible";
  $style = "alert-success";
}
?>
<!doctype html>
<html lang="es">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geo:ital@0;1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom styles for this template -->
    <link href="assets/css/sign-in.css" rel="stylesheet">
    <style>
      body {
        background-image: url("assets/img/Fondos/Fondo1.jpg");
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        font-family: "Geo", serif;
        font-weight: 400;
        font-style: normal;
      }

      .formulario {
        background-color: rgba(255, 255, 255, 0.77);
        border: 0px solid white;
        border-radius: 2.5rem;
      }

      section {
        position: absolute;
        top: 95%;
        left: 82%;
      }
    </style>
  </head>

  <body class="d-flex align-items-center py-4 bg-body-tertiary">
    <main class="form-signin w-100 m-auto formulario">
      <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
        <center><img class="mb-4" src="assets/img/Digimon.png" alt="" width="150"></center>
        <div class="alert <?= $style . ' ' . $visibilidad ?>"><?= $msg ?></div>
        <h1 class="h3 mb-3 fw-normal">Inicio de Sesión</h1>
        <div class="form-floating">
          <input type="usuario" class="form-control" id="usuario" name="usuario" value="<?= $user ?>">
          <label for="usuario">Usuario</label>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control" id="password" name="password" value="<?= $password ?>" placeholder="Password">
          <label for="password">Contraseña</label>
        </div>
        <div class="form-check text-start my-3">
          <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
          <label class="form-check-label" for="flexCheckDefault">
            Recuerdame
          </label>
        </div>
        <button class="btn btn-primary w-100 py-2" type="submit">Iniciar Sesión</button>
      </form>
      <section class="btn btn-success">
          <a href="index.php?tabla=usuarios&accion=crear&id=<?= $_SESSION["usuario"]->id ?>" class="btn-crear">Crear Usuario</a>
      </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>