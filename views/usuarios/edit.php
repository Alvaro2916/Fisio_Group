<?php
require_once "controllers/usuariosController.php";
//recoger datos
if (!isset($_REQUEST["id"])) {
    header('location:index.php?tabla=usuarios&accion=buscar&evento=todos');
    unset($_SESSION["datos"]);
    unset($_SESSION["errores"]);
    exit();
}
$id = $_REQUEST["id"];
$controlador = new UsuariosController();
$user = $controlador->ver($id);

$visibilidad = "hidden";
$mensaje = "";
$clase = "alert alert-success";
$mostrarForm = true;
if ($user == null) {
    $visibilidad = "visibility";
    $mensaje = "El usuario con id: {$id} no existe. Por favor vuelva a la pagina anterior";
    $clase = "alert alert-danger";
    $mostrarForm = false;
} else if (isset($_REQUEST["evento"]) && $_REQUEST["evento"] == "modificar") {
    $visibilidad = "visibility";
    $mensaje = "Usuario {$user->nombre} con id {$id} - Modificado con éxito";
    if (isset($_REQUEST["error"])) {
        $mensaje = "No se ha podido modificar el {$user->nombre} con id {$id}";
        $clase = "alert alert-danger";
    }
}

const PERMISOS = [
    "Administrador" => "1",
    "Usuario" => "0",
  ];

?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Editar Usuario: <?= $_SESSION["datos"]["usuario"] ?? $user->nombre ?> con Id: <?= $id ?> </h1>
    </div>
    <div id="contenido">
        <div id="msg" name="msg" class="<?= $clase ?>" <?= $visibilidad ?>> <?= $mensaje ?> </div>
        <?php
        if ($mostrarForm) {
            $errores = $_SESSION["errores"] ?? [];
        ?>
            <form action="index.php?tabla=usuarios&accion=guardar&evento=modificar&nombre=<?= $user->nombre ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id" value="<?= $user->id ?>">
                <input type="hidden" id="imagen" name="imagen" value="<?= $user->imagen ?>">
                <div class="form-group">
                    <label for="nombre">Nombre </label>
                    <input type="text" class="form-control" id="nombre" name="nombre" aria-describedby="nombre" value="<?= $_SESSION["datos"]["nombre"] ?? $user->nombre ?>">
                    <input type="hidden" id="nombreOriginal" name="nombreOriginal" value="<?= $user->nombre ?>">
                    <?= isset($errores["nombre"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "nombre") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" required class="form-control" id="apellidos" name="apellidos" value="<?= $_SESSION["datos"]["apellidos"] ?? $user->apellidos ?>">
                    <?= isset($errores["apellidos"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "apellidos") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="contrasenya">Contraseña </label>
                    <input type="password" class="form-control" id="contrasenya" name="contrasenya" value="<?= $_SESSION["datos"]["contrasenya"] ?? $user->contrasenya ?>">
                    <?= isset($errores["contrasenya"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "contrasenya") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="telefono">Telefono</label>
                    <input type="text" required class="form-control" id="telefono" name="telefono" value="<?= $_SESSION["datos"]["telefono"] ?? $user->telefono ?>">
                    <?= isset($errores["telefono"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "telefono") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="edad">Edad</label>
                    <input type="text" required class="form-control" id="edad" name="edad" value="<?= $_SESSION["datos"]["edad"] ?? $user->edad ?>">
                    <?= isset($errores["edad"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "edad") . '</div>' : ""; ?>
                </div>
                <div class="form-group">
                    <label for="gmail">Gmail </label>
                    <input type="text" class="form-control" id="gmail" name="gmail" value="<?= $_SESSION["datos"]["gmail"] ?? $user->gmail ?>">
                    <?= isset($errores["gmail"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "gmail") . '</div>' : ""; ?>
                </div>
                <?php if ($_SESSION["usuario"]->permisos == 1) {?>
                    <div class="form-group">
                        <label for="descripcion">Descripcion </label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?= $_SESSION["datos"]["descripcion"] ?? $user->descripcion ?>">
                        <?= isset($errores["descripcion"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "descripcion") . '</div>' : ""; ?>
                    </div>
                    <div class="form-group">
                        <label for="permisos">Permisos </label>
                        <input type="text" class="form-control" id="permisos" name="permisos" value="<?= $_SESSION["datos"]["permisos"] ?? $user->permisos ?>">
                        <?= isset($errores["permisos"]) ? '<div class="alert alert-danger" role="alert">' . DibujarErrores($errores, "permisos") . '</div>' : ""; ?>
                    </div>
                <?php } ?>
                
                <br><button type="submit" class="btn btn-primary"><i class="fa-solid fas fa-check"></i> Guardar</button>
                <?php
                if (isset($_REQUEST["buscar"])) {
                ?>
                    <a class="btn btn-danger" href="index.php"><i class="fa-solid fas fa-ban"></i> Cancelar</a>
                <?php
                } else {
                ?>
                    <a class="btn btn-danger" href="index.php"><i class="fa-solid fas fa-ban"></i> Cancelar</a>
                <?php
                }
                ?>
            </form>
        <?php
        } else {
        ?>
            <?php
            if (isset($_REQUEST["buscar"])) {
            ?>
                <a class="btn btn-danger" href="index.php">Cancelar</a>
            <?php
            } else {
            ?>
                <a class="btn btn-danger" href="index.php">Cancelar</a>
            <?php
            }
            ?>
        <?php
        }
        //Una vez mostrados los errores, los eliminamos
        unset($_SESSION["datos"]);
        unset($_SESSION["errores"]);
        ?>
    </div>
</main>