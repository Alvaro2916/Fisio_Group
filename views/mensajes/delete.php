<?php
require_once "controllers/mensajesController.php";
//pagina invisible
if (!isset ($_REQUEST["id"])){
   header('location:index.php' );
   exit();
}
//recoger datos
$id=$_REQUEST["id"];

$controlador= new MensajesController();
$borrado=$controlador->borrar($id);