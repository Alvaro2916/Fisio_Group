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
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="text-center mb-4 text-primary">Crear nueva cita</h1>
  </div>
  <div id="contenido">
    <!-- Imagen del cuerpo -->
    <div>
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
    <div class="alert alert-danger <?= $visibilidad ?>"><?= $cadena ?></div>
    <form action="index.php?tabla=mensajes&accion=guardar&evento=crear" method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="nombre_cliente" class="form-label">Nombre del paciente</label>
        <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" 
          value="<?= $_SESSION["usuario"]->nombre ?>" readonly>
      </div>

      <div class="mb-3">
        <label for="titulo_cita" class="form-label">Título de la cita</label>
        <input type="text" class="form-control" id="titulo_cita" name="titulo_cita" required>
      </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción del dolor o lesión</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label for="zona" class="form-label">Zona del cuerpo</label>
                <input type="text" class="form-control" id="zonaInput" name="zona_dolorida" readonly required>
            </div>

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha de la cita</label>
                <input type="date" class="form-control" id="fecha" name="fecha_cita" required>
            </div>

            <div class="mb-3">
                <label for="fisio" class="form-label">Fisioterapeuta</label>
                <select class="form-select" id="fisio" name="id_fisio" required>
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
      <br><button type="submit" class="btn btn-primary"><i class="fa-solid fas fa-check"></i> Guardar</button>
      <a href="index.php" class="btn btn-danger"><i class="fa-solid fas fa-ban"></i> Cancelar</a>
    </form>

    <?php
    //Una vez mostrados los errores, los eliminamos
    unset($_SESSION["datos"]);
    unset($_SESSION["errores"]);
    ?>
  </div>
</main>