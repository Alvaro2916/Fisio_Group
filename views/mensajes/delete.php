<?php
require_once "controllers/usuariosController.php";
//pagina invisible
if (!isset ($_REQUEST["id"])){
   header('location:index.php' );
   exit();
}
//recoger datos
$id=$_REQUEST["id"];

$controlador= new UsuariosController();
$borrado=$controlador->borrar($id);