<?php
require_once "assets/php/funciones.php";
$cadenaErrores = "";
$cadena = "";
$errores = [];
$datos = [];
$visibilidad = "invisible";
if (isset($_REQUEST["error"])) {
  $errores = ($_SESSION["errores"]) ?? [];
  $datos = ($_SESSION["datos"]) ?? [];
  $cadena = "Atención Se han producido Errores";
  $visibilidad = "visible";
}

const PERMISOS = [
  "Fisioterapeuta" => "1",
  "Usuario" => "0",
];
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h3">Añadir usuario</h1>
  </div>
  <div id="contenido">
    <div class="alert alert-danger <?= $visibilidad ?>"><?= $cadena ?></div>
    <form action="index.php?tabla=usuarios&accion=guardar&evento=crear" method="POST" enctype="multipart/form-data">
    <input type="hidden" id="permisos" name="permisos" value="0">
      <div class="form-group">
        <label for="nombre">Nombre </label>
        <input type="text" required class="form-control" id="nombre" name="nombre" value="<?= $_SESSION["datos"]["nombre"] ?? "" ?>" aria-describedby="nombre" placeholder="Introduce tu nombre">
        <small id="usuario" class="form-text text-muted">Compartir tu usuario lo hace menos seguro.</small>
        <?= isset($errores["nombre"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "nombre") . '</div>' : ""; ?>
      </div>
      <div class="form-group">
        <label for="apellidos">Apellidos</label>
        <input type="text" required class="form-control" id="apellidos" name="apellidos" value="<?= $_SESSION["datos"]["apellidos"] ?? "" ?>" placeholder="Introduce tus apellidos">
        <?= isset($errores["apellidos"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "apellidos") . '</div>' : ""; ?>
      </div>
      <div class="form-group">
        <label for="contrasenya">Contraseña</label>
        <input type="password" required class="form-control" id="contrasenya" name="contrasenya" value="<?= $_SESSION["datos"]["contrasenya"] ?? "" ?>" placeholder="Contraseña">
        <?= isset($errores["contrasenya"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "contrasenya") . '</div>' : ""; ?>
      </div>
      <div class="form-group">
        <label for="imagen">Sube tu foto de perfil (opcional) </label>
        <input type="file" class="form-control" id="imagen" name="imagen" value="<?= $_SESSION["datos"]["imagen"] ?? "" ?>" placeholder="Introduce la Imagen (opcional)">
        <?= isset($errores["imagen"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "imagen") . '</div>' : ""; ?>
      </div>
      <div class="form-group">
        <label for="telefono">Telefono </label>
        <input type="text" required class="form-control" id="telefono" name="telefono" value="<?= $_SESSION["datos"]["telefono"] ?? "" ?>" aria-describedby="telefono" placeholder="Introduce tu telefono">
        <?= isset($errores["telefono"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "telefono") . '</div>' : ""; ?>
      </div>
      <div class="form-group">
        <label for="edad">Edad </label>
        <input type="text" required class="form-control" id="edad" name="edad" value="<?= $_SESSION["datos"]["edad"] ?? "" ?>" aria-describedby="edad" placeholder="Introduce tu edad">
        <?= isset($errores["edad"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "edad") . '</div>' : ""; ?>
      </div>
      <div class="form-group">
        <label for="gmail">Gmail </label>
        <input type="text" required class="form-control" id="gmail" name="gmail" value="<?= $_SESSION["datos"]["gmail"] ?? "" ?>" aria-describedby="gmail" placeholder="Introduce tu gmail">
        <?= isset($errores["gmail"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "gmail") . '</div>' : ""; ?>
      </div>
      <?php if ($_SESSION["usuario"]->permisos == 1) {?>
        <div class="form-group">
          <label for="descripcion">Descripcion </label>
          <input type="text" required class="form-control" id="descripcion" name="descripcion" value="<?= $_SESSION["datos"]["descripcion"] ?? "" ?>" aria-describedby="descripcion" placeholder="Introduce tu descripcion">
          <?= isset($errores["descripcion"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "descripcion") . '</div>' : ""; ?>
        </div>
      <?php } ?>
      <br><button type="submit" class="btn btn-primary"><i class="fa-solid fas fa-check"></i> Guardar</button>
      <a href="login.php" class="btn btn-danger"><i class="fa-solid fas fa-ban"></i> Cancelar</a>
    </form>

    <?php
    //Una vez mostrados los errores, los eliminamos
    unset($_SESSION["datos"]);
    unset($_SESSION["errores"]);
    ?>
  </div>
</main>