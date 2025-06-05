<?php
require_once "models/mensajesModel.php";
require_once "assets/php/funciones.php";

class MensajesController
{
    private $model;

    public function __construct()
    {
        $this->model = new MensajesModel();
    }

    public function crear(array $arrayMensaje): void
    {
        $error = false;
        $errores = [];

        $_SESSION["errores"] = [];
        $_SESSION["datos"] = [];

        $arrayNoNulos = ["nombre_cliente"];
        $nulos = HayNulos($arrayNoNulos, $arrayMensaje);

        if (count($nulos) > 0) {
            $error = true;
            foreach ($nulos as $campo) {
                $errores[$campo][] = "El campo {$campo} es nulo";
            }
        }

        if ($error) {
            $_SESSION["errores"] = $errores;
            $_SESSION["datos"] = $arrayMensaje;
            header("location:index.php?accion=crear&tabla=mensajes&error=true");
            exit();
        }

        $id = $this->model->insert($arrayMensaje);

        if ($id !== null) {
            unset($_SESSION["errores"]);
            unset($_SESSION["datos"]);
            header("Location: index.php");
            exit;
        } else {
            echo "Error al crear mensaje";
        }
    }

    public function ver($id_cliente): array
    {
        $datos = $this->model->read($id_cliente);
        return is_array($datos) ? $datos : []; // Devolver array vacío en vez de null
    }
    
    public function verFisio(int $id): ?array
    {
        return $this->model->readFisio($id);
    }

    public function verEditar(int $id): ?stdClass
    {
        return $this->model->readEdit($id);
    }

    public function listar(): array
    {
        return $this->model->readAll();
    }

    public function borrar(int $id): void
    {
        $borrado = $this->model->delete($id);
        $url = "location:index.php?accion=buscar&tabla=mensajes";
        if (!$borrado) $url .= "&error=true";
        header($url);
        exit();
    }

    public function editar(string $id, array $arrayMensaje): void
    {
        $error = false;
        $errores = [];

        unset($_SESSION["errores"], $_SESSION["datos"]);

        $arrayNoNulos = ["nombre_cliente"];
        $nulos = HayNulos($arrayNoNulos, $arrayMensaje);

        if (count($nulos) > 0) {
            $error = true;
            foreach ($nulos as $campo) {
                $errores[$campo][] = "El campo {$campo} es nulo";
            }
        }

        $editado = false;
        if (!$error) {
            $editado = $this->model->edit($id, $arrayMensaje);
        }

        if ($editado) {
            unset($_SESSION["errores"], $_SESSION["datos"]);
            $url = "location:index.php?accion=editar&tabla=mensajes&evento=modificar&id={$id}";
        } else {
            $_SESSION["errores"] = $errores;
            $_SESSION["datos"] = $arrayMensaje;
            $url = "location:index.php?accion=editar&tabla=mensajes&evento=modificar&id={$id}&error=true";
        }

        header($url);
        exit();
    }

    public function buscar(string $campo = "nombre_cliente", string $metodo = "contiene", string $texto = ""): array
    {
        return $this->model->search($campo, $metodo, $texto);
    }

    public function calendario(): void {
        $citasPorDia = $this->model->getCitasDelMesActual();

        // Pasamos datos a la vista
        require_once 'views/mensajes/calendario.php';
    }
}
