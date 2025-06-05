<?php
require_once "controllers/mensajesController.php";
//recoger datos
if (!isset($_REQUEST["nombre_cliente"])) {
    header('Location:index.php?tabla=mensajes&accion=crear');
    exit();
}

$id = ($_REQUEST["id"]) ?? ""; //el id me servirá en editar

$arrayUser = [
    "id" => $id,
    "id_cliente" => $_REQUEST["id_cliente"],
    "nombre_cliente" => $_REQUEST["nombre_cliente"],
    "titulo_cita" => $_REQUEST["titulo_cita"] ?? "",
    "descripcion" => $_REQUEST["descripcion"] ?? "",
    "zona_dolorida" => $_REQUEST["zona_dolorida"] ?? "",
    "fecha_cita" => $_REQUEST["fecha_cita"],
    "id_fisio" => $_REQUEST["id_fisio"] ?? "",
    "estado" => $_REQUEST["estado"] ?? "enviado",
];

//pagina invisible
$controlador = new MensajesController();

if ($_REQUEST["evento"] == "crear") {
    $controlador->crear($arrayUser);
}

if ($_REQUEST["evento"] == "modificar") {
    $controlador->editar($id, $arrayUser);
}
