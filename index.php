<?php
ob_start();
require_once "config/sessionControl.php";
require_once("router/router.php");

require_once("views/layout/head.php");
$vista = router();

if (!file_exists($vista)) "Error, REVISA TUS RUTAS";
else require_once($vista);

require_once("views/layout/footer.php");

$vista = router();
?>
<div class="container-fluid">
    <div class="row">
        <?php
        //Si quitamos esto no se vería el navbar pero no se cuadraría nuestra página. Tenemos que verlo bien


        if (!file_exists($vista)) echo "Error, REVISA TUS RUTAS";
        else require_once($vista);

        $vistasArray = [
            "crear" => "views/usuarios/create.php",
            "guardar" => "views/usuarios/store.php",
            "ver" => "views/usuarios/show.php",
            "buscar" => "views/usuarios/search.php",
            "borrar" => "views/usuarios/delete.php",
            "editar" => "views/usuarios/edit.php",
            "mensaje" => "views/usuarios/mensaje.php",
            "administrar" => "views/usuarios/administrar.php",
        ];

        foreach ($vistasArray as $key => $vistaAlt) {
            if ($vista == $vistaAlt) {
                require_once($vista);
            }
        }


        ?>
    </div>
</div>
<?php
require_once("views/layout/footer.php");
?>