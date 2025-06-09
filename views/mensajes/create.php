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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="text-center mb-4 text-primary">Crear nueva cita</h1>
  </div>

  <div id="contenido" class="body-container">

    <!-- Imagen cuerpo humano -->
    <div class="imagen-cuerpo">
      <img src="assets/img/cuerpo.jpg" alt="Cuerpo humano" usemap="#zonas" class="cuerpo-img">
      
        <div class="zona cabeza"></div>
        <div class="zona brazo-derecho"></div>
        <div class="zona brazo-izquierdo"></div>
        <div class="zona torso"></div>
        <div class="zona muslo-derecho"></div>
        <div class="zona muslo-izquierdo"></div>
        <div class="zona pierna-derecha"></div>
        <div class="zona pierna-izquierda"></div>
        <div class="zona tobillo-derecho"></div>
        <div class="zona tobillo-izquierdo"></div>
      

      <div id="zonaSeleccionada" class="zona-info text-center">Haz clic en una zona del cuerpo</div>
      <map name="zonas">
        <area shape="circle" coords="200,60,30" href="#" alt="Cabeza" data-zona="Cabeza">
        <area shape="rect" coords="230,110,270,220" href="#" alt="Brazo Derecho" data-zona="Brazo Derecho">
        <area shape="rect" coords="135,110,175,220" href="#" alt="Brazo Izquierdo" data-zona="Brazo Izquierdo">
        <area shape="rect" coords="170,100,230,220" href="#" alt="Torso" data-zona="Torso">
        <area shape="rect" coords="200,220,230,310" href="#" alt="Muslo Derecho" data-zona="Muslo Derecho">
        <area shape="rect" coords="170,220,200,310" href="#" alt="Muslo Izquierdo" data-zona="Muslo Izquierdo">
        <area shape="rect" coords="205,310,225,370" href="#" alt="Pierna Derecha" data-zona="Pierna Derecha">
        <area shape="rect" coords="175,310,195,370" href="#" alt="Pierna Izquierda" data-zona="Pierna Izquierda">
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
        <label for="fecha_cita" class="form-label">Fecha y hora de la cita</label>
        <input type="text" class="form-control" id="fecha_cita" name="fecha_cita"
          value="<?= $_SESSION["datos"]["fecha_cita"] ?? "" ?>" required placeholder="Selecciona fecha y hora">
        <?= isset($errores["fecha_cita"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "fecha_cita") . '</div>' : ""; ?>
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
      <a class="btn btn-danger" href="index.php"><i class="fa-solid fas fa-ban"></i> Cancelar</a>
    </form>

    <?php
    unset($_SESSION["datos"]);
    unset($_SESSION["errores"]);
    ?>
  </div>
</main>

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Inicializar Flatpickr -->
<script>
  flatpickr("#fecha_cita", {
    enableTime: true,
    dateFormat: "Y-m-d H:i",
    time_24hr: true,
    minDate: "today"
  });

  document.querySelectorAll('area').forEach(area => {
    area.addEventListener('click', function (e) {
      e.preventDefault();
      const zona = this.dataset.zona;
      document.getElementById('zona_dolorida').value = zona;
      document.getElementById('zonaSeleccionada').textContent = "Zona seleccionada: " + zona;
    });
  });
</script>
