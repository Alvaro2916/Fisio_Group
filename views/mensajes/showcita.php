<?php
require_once "controllers/mensajesController.php";

$mensaje = "";
$clase = "alert alert-success";
$visibilidad = "hidden";
$mostrarDatos = false;
$controlador = new MensajesController();
$user = "";
$campo = "";
$modo = "";
$usuarios = $controlador->ver($_SESSION["usuario"]->id);
$mostrarDatos = true;
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Ver tus citas</h1>
    </div>
    <div id="contenido">
        <div class="<?= $clase ?>" <?= $visibilidad ?> role="alert">
            <?= $mensaje ?>
        </div>
        <?php if ($mostrarDatos): ?>
            <table class="table table-light table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Titulo de la cita</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Zona Afectada</th>
                        <th scope="col">Fecha de la cita</th>
                        <th scope="col">Fisioterapeuta</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Editar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <th><?= $usuario["nombre_cliente"] ?></th>
                            <td><?= $usuario["titulo_cita"] ?></td>
                            <td><?= $usuario["descripcion"] ?></td>
                            <td><?= $usuario["zona_dolorida"] ?></td>
                            <td><?= $usuario["fecha_cita"] ?></td>
                            <td><?= $usuario["id_fisio"] ?></td>
                            <td><?= $usuario["estado"] ?></td>
                            <td><a class="btn btn-primary" href="index.php?tabla=mensajes&accion=editar&id=<?= $usuario["id"] ?>"><i class="fa-solid fas fa-user-tie"></i> Editar Cita</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="index.php" class="btn btn-primary"><i class="fa-solid fas fa-chevron-left"></i> Volver a Inicio</a>
        <?php endif; ?>
    </div>
</main>
