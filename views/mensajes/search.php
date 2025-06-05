<?php
require_once "controllers/mensajesController.php";

$mensaje_error = "";
$clase = "alert alert-success";
$visibilidad = "hidden";
$mostrarDatos = false;
$controlador = new MensajesController();
$user = "";
$campo = "";
$modo = "";

if (isset($_REQUEST["evento"])) {
    $mostrarDatos = true;
    switch ($_REQUEST["evento"]) {
        case "todos":
            $mensajes = $controlador->listar();
            $mostrarDatos = true;
            break;
        case "filtrar":
            $campo = ($_REQUEST["campo"]) ?? "nombre";
            $metodo = ($_REQUEST["modo"]) ?? "contiene";
            $texto = ($_REQUEST["busqueda"]) ?? "";
            //es borrable Parametro con nombre
            $mensajes = $controlador->buscar($campo, $metodo, $texto); //solo añadimos esto
            break;
    }
} ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Buscar Cita</h1>
    </div>
    <div id="contenido">
        <div class="<?= $clase ?>" <?= $visibilidad ?> role="alert">
            <?= $mensaje_error ?>
        </div>
        <div>
            <form action="index.php?tabla=mensajes&accion=buscar&evento=filtrar" method="POST">
                <div class="form-group">
                    <label for="usuario">Buscar Cita</label><br>
                    <select class="form-select" aria-label="Default select example" id="campo" name="campo">
                        <option value="id_cliente">ID Cliente</option>
                        <option value="nombre_cliente" selected>Nombre del Cliente</option>
                        <option value="fecha_cita">Fecha</option>
                        <option value="id_fisio">Id Fisioterapeuta</option>
                    </select>
                    <select class="form-select" aria-label="Default select example" id="modo" name="modo">
                        <option value="empieza" selected>Empieza Por</option>
                        <option value="acaba">Acaba En</option>
                        <option value="contiene">Contiene</option>
                        <option value="igual">Igual A</option>
                    </select>
                    <input type="text" required class="form-control" id="busqueda" name="busqueda" value="<?= $user ?>" placeholder="Buscar por Usuario">
                </div>
                <button type="submit" class="btn btn-success" name="Filtrar"><i class="fas fa-search"></i> Buscar</button>
            </form>
            <!-- Este formulario es para ver todos los datos    -->
            <form action="index.php?tabla=mensajes&accion=buscar&evento=todos" method="POST">
                <button type="submit" class="btn btn-info" name="Todos"><i class="fas fa-list"></i> Listar</button>
            </form>
        </div>
        <?php
        if ($mostrarDatos) {
        ?>
            <table class="table table-light table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID Cliente</th>
                        <th scope="col">Nombre Cliente</th>
                        <th scope="col">Titulo de la cita</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Zona dolorida</th>
                        <th scope="col">Fecha de la cita</th>
                        <th scope="col">ID Fisio</th>
                        <th scope="col">Estado de la cita</th>
                        <th scope="col">Editar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mensajes as $mensaje) :
                        $id = $mensaje->id;
                    ?>
                        <tr>
                            <th scope="row"><?= $mensaje->id_cliente ?></th>
                            <td><?= $mensaje->nombre_cliente ?></td>
                            <td><?= $mensaje->titulo_cita ?></td>
                            <td><?= $mensaje->descripcion ?></td>
                            <td><?= $mensaje->zona_dolorida ?></td>
                            <td><?= $mensaje->fecha_cita ?></td>
                            <td><?= $mensaje->id_fisio ?></td>
                            <td><?= $mensaje->estado ?></td>
                            <td scope="col"><a class="btn btn-primary" href="index.php?tabla=mensajes&accion=editar&id=<?= $mensaje->id_cliente ?>"><i class="fa-solid fas fa-user-tie"></i> Ver Mensaje</a></td>
                    <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
            <a href="index.php?tabla=mensajes&accion=administrar" class="btn btn-primary"><i class="fa-solid fas fa-chevron-left"></i> Volver a Inicio</a>
        <?php
        }
        ?>
    </div>
</main>