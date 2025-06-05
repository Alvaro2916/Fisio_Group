<?php
require_once "models/mensajesModel.php";
require_once "assets/php/funciones.php";

class MensajesController
{
    private $model;

    private $inventario;

    public function __construct()
    {
        $this->model = new MensajesModel();
    }

    public function crear(array $arrayUser): void
    {
        $error = false;
        $errores = [];
        //vaciamos los posibles errores
        $_SESSION["errores"] = [];
        $_SESSION["datos"] = [];

        // ERRORES DE TIPO

        //campos NO VACIOS
        $arrayNoNulos = ["nombre_cliente"];
        $nulos = HayNulos($arrayNoNulos, $arrayUser);
        if (count($nulos) > 0) {
            $error = true;
            for ($i = 0; $i < count($nulos); $i++) {
                $errores[$nulos[$i]][] = "El campo {$nulos[$i]} es nulo";
            }
        }

        $id = null;
        if (!$error) $id = 1;

        if ($id == null) {
            $_SESSION["errores"] = $errores;
            $_SESSION["datos"] = $arrayUser;
            header("location:index.php?accion=crear&tabla=usuarios&error=true&id={$id}");
            exit();
        } else {
            unset($_SESSION["errores"]);
            unset($_SESSION["datos"]);

            $id = $this->model->insert($arrayUser);

            if ($id !== null) {
                header("Location: index.php?tabla=usuarios&accion=administrar");
                exit;
            } else {
                // Mostrar error o volver al formulario
                echo "Error al crear usuario";
            }
            exit();
        }
    }

    public function ver(int $id): ?stdClass
    {
        return $this->model->read($id);
    }

    public function listar()
    {
        $users = $this->model->readAll();
        return $users;
    }

    public function borrar(int $id): void
    {
        $usuario = $this->ver($id);

        $borrado = $this->model->delete($id);
        $redireccion = "location:index.php?accion=buscar&tabla=usuarios";

        if ($borrado == false) $redireccion .=  "&error=true";
        header($redireccion);
        exit();
    }


    public function editar(string $id, array $arrayUser): void
    {
        $error = false;
        $errores = [];
        if (isset($_SESSION["errores"])) {
            unset($_SESSION["errores"]);
            unset($_SESSION["datos"]);
        }

        // ERRORES DE TIPO

        //campos NO VACIOS
        $arrayNoNulos = ["nombre_cliente"];
        $nulos = HayNulos($arrayNoNulos, $arrayUser);
        if (count($nulos) > 0) {
            $error = true;
            for ($i = 0; $i < count($nulos); $i++) {
                $errores[$nulos[$i]][] = "El campo {$nulos[$i]} es nulo";
            }
        }

        //todo correcto
        $editado = false;
        if (!$error) $editado = $this->model->edit($id, $arrayUser);

        if ($editado) {
            unset($_SESSION["errores"]);
            unset($_SESSION["datos"]);
            $id = $arrayUser["id"];
            $redireccion = "location:index.php?accion=editar&tabla=usuarios&evento=modificar&id={$id}";
        } else {
            $_SESSION["errores"] = $errores;
            $_SESSION["datos"] = $arrayUser;
            $redireccion = "location:index.php?accion=editar&tabla=usuarios&evento=modificar&id={$id}&error=true";
        }

        header($redireccion);
        exit();
        //vuelvo a la pagina donde estaba
    }

    public function buscar(string $campo = "nombre", string $metodo = "contiene", string $texto = ""): array
    {
        $users = $this->model->search($campo, $metodo, $texto);
        return $users;
    }
}
