<?php
require_once "controllers/usuariosController.php";

$mensaje = "";
$clase = "alert alert-success";
$visibilidad = "hidden";
$mostrarDatos = false;
$controlador = new UsuariosController();
$user = "";
$campo = "";
$modo = "";

if (isset($_REQUEST["evento"])) {
    $mostrarDatos = true;
    switch ($_REQUEST["evento"]) {
        case "todos":
            $usuarios = $controlador->listar();
            $mostrarDatos = true;
            break;
        case "filtrar":
            $campo = ($_REQUEST["campo"]) ?? "nombre";
            $metodo = ($_REQUEST["modo"]) ?? "contiene";
            $texto = ($_REQUEST["busqueda"]) ?? "";
            //es borrable Parametro con nombre
            $usuarios = $controlador->buscar($campo, $metodo, $texto); //solo añadimos esto
            break;
    }
} ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h3">Buscar Usuario</h1>
    </div>
    <div id="contenido">
        <div class="<?= $clase ?>" <?= $visibilidad ?> role="alert">
            <?= $mensaje ?>
        </div>
        <div>
            <form action="index.php?tabla=usuarios&accion=buscar&evento=filtrar" method="POST">
                <div class="form-group">
                    <label for="usuario">Buscar Usuario</label><br>
                    <select class="form-select" aria-label="Default select example" id="campo" name="campo">
                        <option value="id">ID</option>
                        <option value="nombre" selected>Nombre</option>
                        <option value="gmail">Gmail</option>
                        <option value="permisos">Fisioterapeuta (1)</option>
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
            <form action="index.php?tabla=usuarios&accion=buscar&evento=todos" method="POST">
                <button type="submit" class="btn btn-info" name="Todos"><i class="fas fa-list"></i> Listar</button>
            </form>
        </div>
        <?php
        if ($mostrarDatos) {
        ?>
            <table class="table table-light table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">Telefono</th>
                        <th scope="col">Edad</th>
                        <th scope="col">Gmail</th>
                        <th scope="col">Editar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario) :
                        $id = $usuario->id;
                    ?>
                        <tr>
                            <th scope="row"><?= $usuario->id ?></th>
                            <td><?= $usuario->nombre ?></td>
                            <td><?= $usuario->apellidos ?></td>
                            <td><?= $usuario->telefono ?></td>
                            <td><?= $usuario->edad ?></td>
                            <td><?= $usuario->gmail ?></td>
                            <td scope="col"><a class="btn btn-primary" href="index.php?tabla=usuarios&accion=ver&id=<?= $usuario->id ?>&buscar=true"><i class="fa-solid fas fa-user-tie"></i> Ver Usuario</a></td>
                    <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
            <a href="index.php?tabla=usuarios&accion=administrar" class="btn btn-primary"><i class="fa-solid fas fa-chevron-left"></i> Volver a Inicio</a>
        <?php
        }
        ?>
    </div>
</main>