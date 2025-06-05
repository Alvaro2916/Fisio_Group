<?php
require_once "controllers/mensajesController.php";
require_once "controllers/usuariosController.php";

// recoger datos
if (!isset($_REQUEST["id"])) {
    header('location:index.php?tabla=mensajes&accion=buscar&evento=todos');
    unset($_SESSION["datos"]);
    unset($_SESSION["errores"]);
    exit();
}

$id = $_REQUEST["id"];
$controlador = new MensajesController();
$mensaje_cita = $controlador->verEditar($id);


$visibilidad = "hidden";
$mensaje = "";
$clase = "alert alert-success";
$mostrarForm = true;

if ($mensaje_cita == null) {
    $visibilidad = "visibility";
    $mensaje = "El usuario con id: {$id} no existe. Por favor vuelva a la pagina anterior";
    $clase = "alert alert-danger";
    $mostrarForm = false;
} else if (isset($_REQUEST["evento"]) && $_REQUEST["evento"] == "modificar") {
    $visibilidad = "visibility";
    $mensaje = "Cita {$mensaje_cita->titulo_cita} con id {$id} - Modificado con éxito";
    if (isset($_REQUEST["error"])) {
        $mensaje = "No se ha podido modificar la cita {$mensaje_cita->titulo_cita} con id {$id}";
        $clase = "alert alert-danger";
    }
}

// Permisos
$permisosUsuario = $_SESSION["usuario"]->permisos;
$soloPuedeEditarEstado = $permisosUsuario == 1;
$soloPuedeEditarTodoMenosEstado = $permisosUsuario == 0;

?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Editar tu Cita: </h1>
    </div>
    <div id="contenido">
        <div id="msg" name="msg" class="<?= $clase ?>" <?= $visibilidad ?>> <?= $mensaje ?> </div>
        <?php if ($mostrarForm): $errores = $_SESSION["errores"] ?? []; ?>
            <form action="index.php?tabla=mensajes&accion=guardar&evento=modificar&nombre=<?= $mensaje_cita->nombre_cliente ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id" value="<?= $mensaje_cita->id ?>">    
                <input type="hidden" id="id_cliente" name="id_cliente" value="<?= $mensaje_cita->id_cliente ?>">
                <div class="form-group">
                    <label for="nombre_cliente">Nombre </label>
                    <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente"
                        value="<?= $_SESSION["datos"]["nombre_cliente"] ?? $mensaje_cita->nombre_cliente ?>"
                        <?= $soloPuedeEditarEstado ? 'readonly' : '' ?>>
                    <?= isset($errores["nombre_cliente"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "nombre_cliente") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="titulo_cita">Título de la cita</label>
                    <input type="text" class="form-control" id="titulo_cita" name="titulo_cita"
                        value="<?= $_SESSION["datos"]["titulo_cita"] ?? $mensaje_cita->titulo_cita ?>"
                        <?= $soloPuedeEditarEstado ? 'readonly' : '' ?>>
                    <?= isset($errores["titulo_cita"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "titulo_cita") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion"
                        value="<?= $_SESSION["datos"]["descripcion"] ?? $mensaje_cita->descripcion ?>"
                        <?= $soloPuedeEditarEstado ? 'readonly' : '' ?>>
                    <?= isset($errores["descripcion"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "descripcion") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="zona_dolorida">Zona Afectada</label>
                    <input type="text" class="form-control" id="zona_dolorida" name="zona_dolorida"
                        value="<?= $_SESSION["datos"]["zona_dolorida"] ?? $mensaje_cita->zona_dolorida ?>"
                        <?= $soloPuedeEditarEstado ? 'readonly' : '' ?>>
                    <?= isset($errores["zona_dolorida"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "zona_dolorida") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="fecha_cita">Fecha de la cita</label>
                    <input type="date" class="form-control" id="fecha_cita" name="fecha_cita"
                        value="<?= $_SESSION["datos"]["fecha_cita"] ?? $mensaje_cita->fecha_cita ?>"
                        <?= $soloPuedeEditarEstado ? 'readonly' : '' ?>>
                    <?= isset($errores["fecha_cita"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "fecha_cita") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="id_fisio">Fisioterapeuta</label>
                    <input type="text" class="form-control" id="id_fisio" name="id_fisio"
                        value="<?= $_SESSION["datos"]["id_fisio"] ?? $mensaje_cita->id_fisio ?>"
                        <?= $soloPuedeEditarEstado ? 'readonly' : '' ?>>
                    <?= isset($errores["id_fisio"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "id_fisio") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <?php if ($soloPuedeEditarEstado): ?>
                        <select class="form-control" id="estado" name="estado">
                            <option value="enviado" <?= ($mensaje_cita->estado == 'Enviado') ? 'selected' : '' ?>>Enviado</option>
                            <option value="aceptado" <?= ($mensaje_cita->estado == 'Aceptado') ? 'selected' : '' ?>>Aceptado</option>
                            <option value="rechazado" <?= ($mensaje_cita->estado == 'Rechazado') ? 'selected' : '' ?>>Rechazado</option>
                        </select>
                    <?php else: ?>
                        <input type="text" class="form-control" id="estado" name="estado"
                            value="<?= $_SESSION["datos"]["estado"] ?? $mensaje_cita->estado ?>" readonly>
                    <?php endif; ?>
                    <?= isset($errores["estado"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "estado") . '</div>' : ""; ?>
                </div>

                <br>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fas fa-check"></i> Guardar</button>
                <a class="btn btn-danger" href="index.php"><i class="fa-solid fas fa-ban"></i> Cancelar</a>
            </form>
        <?php else: ?>
            <a class="btn btn-danger" href="index.php">Cancelar</a>
        <?php endif;
        unset($_SESSION["datos"]);
        unset($_SESSION["errores"]);
        ?>
    </div>
</main>
