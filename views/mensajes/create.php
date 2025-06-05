<?php
require_once "assets/php/funciones.php";
require_once('models/usuariosModel.php');
$model = new usuariosModel();
$usuarios = $model->readAll();
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
?>
<style>
  .zona-info {
    font-weight: bold;
    color: #198754;
    margin-top: 15px;
  }

  .cuerpo-img {
    max-width: 100%;
    height: auto;
  }

  .body-container {
    display: flex;
    flex-direction: row-reverse;
    gap: 40px;
    margin-top: 30px;
    flex-wrap: wrap;
    align-items: flex-start;
  }

  form {
    flex: 1;
    min-width: 300px;
  }

  .imagen-cuerpo {
    max-width: 400px;
    flex-shrink: 0;
    text-align: center;
  }
</style>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="text-center mb-4 text-primary">Crear nueva cita</h1>
  </div>

  <div id="contenido" class="body-container">

    <!-- Imagen cuerpo humano -->
    <div class="imagen-cuerpo">
      <img src="assets/img/cuerpo.jpg" alt="Cuerpo humano" usemap="#zonas" class="cuerpo-img">
      <div id="zonaSeleccionada" class="zona-info text-center">Haz clic en una zona del cuerpo</div>

      <map name="zonas">
        <area shape="circle" coords="250,60,30" href="#" alt="Cabeza" data-zona="Cabeza">
        <area shape="rect" coords="60,120,90,220" href="#" alt="Brazo Derecho" data-zona="Brazo Derecho">
        <area shape="rect" coords="170,120,200,220" href="#" alt="Brazo Izquierdo" data-zona="Brazo Izquierdo">
        <area shape="rect" coords="95,100,165,220" href="#" alt="Torso" data-zona="Torso">
        <area shape="rect" coords="95,220,115,310" href="#" alt="Muslo Derecho" data-zona="Muslo Derecho">
        <area shape="rect" coords="145,220,165,310" href="#" alt="Muslo Izquierdo" data-zona="Muslo Izquierdo">
        <area shape="rect" coords="95,310,115,400" href="#" alt="Pierna Derecha" data-zona="Pierna Derecha">
        <area shape="rect" coords="145,310,165,400" href="#" alt="Pierna Izquierda" data-zona="Pierna Izquierda">
        <area shape="circle" coords="105,415,10" href="#" alt="Tobillo Derecho" data-zona="Tobillo Derecho">
        <area shape="circle" coords="155,415,10" href="#" alt="Tobillo Izquierdo" data-zona="Tobillo Izquierdo">
      </map>
    </div>

    <!-- Formulario -->
    <form action="index.php?tabla=mensajes&accion=guardar&evento=crear" method="POST" enctype="multipart/form-data">
      <input type="hidden" id="id_cliente" name="id_cliente" value="<?= $_SESSION["usuario"]->id ?>">  
      <input type="hidden" id="estado" name="estado" value="enviado">

      <div class="alert alert-danger <?= $visibilidad ?>"><?= $cadena ?></div>

      <div class="mb-3">
        <label for="nombre_cliente" class="form-label">Nombre del paciente</label>
        <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" 
          value="<?= $_SESSION["usuario"]->nombre ?>" readonly>
      </div>

      <div class="form-group">
        <label for="titulo_cita">Titulo de la Cita</label>
        <input type="text" required class="form-control" id="titulo_cita" name="titulo_cita"
          value="<?= $_SESSION["datos"]["titulo_cita"] ?? "" ?>" placeholder="Titulo de la cita">
        <?= isset($errores["titulo_cita"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "titulo_cita") . '</div>' : ""; ?>
      </div>

      <div class="form-group">
        <label for="descripcion">Descripción</label>
        <input type="text" required class="form-control" id="descripcion" name="descripcion"
          value="<?= $_SESSION["datos"]["descripcion"] ?? "" ?>" placeholder="Introduce tu descripción">
        <?= isset($errores["descripcion"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "descripcion") . '</div>' : ""; ?>
      </div>

      <div class="form-group">
        <label for="zona_dolorida">Zona Afectada</label>
        <input type="text" required class="form-control" id="zona_dolorida" name="zona_dolorida"
          value="<?= $_SESSION["datos"]["zona_dolorida"] ?? "" ?>" placeholder="Zona afectada">
        <?= isset($errores["zona_dolorida"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "zona_dolorida") . '</div>' : ""; ?>
      </div>

      <div class="mb-3">
        <label for="fecha_cita" class="form-label">Fecha de la cita</label>
        <input type="date" class="form-control" id="fecha_cita" name="fecha_cita" required>
      </div>

      <div class="mb-3">
        <label for="id_fisio" class="form-label">Fisioterapeuta</label>
        <select class="form-select" id="id_fisio" name="id_fisio" required>
          <option value="" selected>Selecciona un fisioterapeuta</option>
          <?php foreach ($usuarios as $usuario): ?>
            <?php if ($usuario->permisos == 1): ?>
              <option value="<?= htmlspecialchars($usuario->id) ?>">
                <?= htmlspecialchars($usuario->nombre) ?>
              </option>
            <?php endif; ?>
          <?php endforeach; ?>
        </select>
      </div>

      <br>
      <button type="submit" class="btn btn-primary"><i class="fa-solid fas fa-check"></i> Guardar</button>
      <a href="index.php?tabla=usuarios&accion=administrar" class="btn btn-danger"><i class="fa-solid fas fa-ban"></i> Cancelar</a>
    </form>

    <?php
    unset($_SESSION["datos"]);
    unset($_SESSION["errores"]);
    ?>
  </div>
</main>

<!-- Script para seleccionar zona -->
<script>
  document.querySelectorAll('area').forEach(area => {
    area.addEventListener('click', function (e) {
      e.preventDefault();
      const zona = this.dataset.zona;
      document.getElementById('zona_dolorida').value = zona;
      document.getElementById('zonaSeleccionada').textContent = "Zona seleccionada: " + zona;
    });
  });
</script>
