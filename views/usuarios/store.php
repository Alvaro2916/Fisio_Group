<?php
require_once "controllers/usuariosController.php";
//recoger datos
if (!isset($_REQUEST["nombre"])) {
    header('Location:index.php?tabla=usuarios&accion=crear');
    exit();
}

$id = ($_REQUEST["id"]) ?? ""; //el id me servirá en editar

$arrayUser = [
    "id" => $id,
    "nombre" => $_REQUEST["nombre"],
    "apellidos" => $_REQUEST["apellidos"] ?? "",
    "permisos" => $_REQUEST["permisos"] ?? 0,
    "contrasenya" => $_REQUEST["contrasenya"] ?? "",
    "descripcion" => $_REQUEST["descripcion"] ?? "",
    "telefono" => $_REQUEST["telefono"] ?? "",
    "edad" => $_REQUEST["edad"] ?? "",
    "gmail" => $_REQUEST["gmail"] ?? "",
];

//pagina invisible
$controlador = new UsuariosController();

if ($_REQUEST["evento"] == "crear") {
    $controlador->crear($arrayUser);
}

if ($_REQUEST["evento"] == "modificar") {
    $controlador->editar($id, $arrayUser);
}
