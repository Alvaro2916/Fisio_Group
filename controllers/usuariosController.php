<?php
require_once "models/usuariosModel.php";
require_once "assets/php/funciones.php";

class UsuariosController
{
    private $model;

    private $inventario;

    public function __construct()
    {
        $this->model = new UsuariosModel();
    }

    public function crear(array $arrayUser): void
    {
        $error = false;
        $errores = [];
        //vaciamos los posibles errores
        $_SESSION["errores"] = [];
        $_SESSION["datos"] = [];

        // ERRORES DE TIPO
        // Validación de edad
        if (isset($arrayUser["edad"])) {
            $edad = (int)$arrayUser["edad"];
            if ($edad < 12 || $edad > 90) {
                $errores["edad"][] = "La edad debe estar entre 12 y 90 años";
                $error = true;
            }
        }
    
        // Validación de gmail
        if (isset($arrayUser["gmail"])) {
            if (!preg_match('/^[\w\.\-]+@gmail\.com$/', $arrayUser["gmail"])) {
                $errores["gmail"][] = "El gmail debe tener formato válido (@gmail.com)";
                $error = true;
            }
        }
    
        // Validación de teléfono
        if (isset($arrayUser["telefono"])) {
            if (!preg_match('/^\d{9}$/', $arrayUser["telefono"])) {
                $errores["telefono"][] = "El teléfono debe contener exactamente 9 dígitos";
                $error = true;
            }
        }
        
        //campos NO VACIOS
        $arrayNoNulos = ["nombre", "contrasenya"];
        $nulos = HayNulos($arrayNoNulos, $arrayUser);
        if (count($nulos) > 0) {
            $error = true;
            for ($i = 0; $i < count($nulos); $i++) {
                $errores[$nulos[$i]][] = "El campo {$nulos[$i]} es nulo";
            }
        }

        //CAMPOS UNICOS
        $arrayUnicos = ["nombre", "apellidos"];

        foreach ($arrayUnicos as $CampoUnico) {
            if ($this->model->exists($CampoUnico, $arrayUser[$CampoUnico])) {
                $errores[$CampoUnico][] = "El {$arrayUser[$CampoUnico]} de {$CampoUnico} ya existe";
                $error = true;
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

            $directorio = "assets/img/usuarios/" . $_REQUEST["nombre"] . "/";
            if (!file_exists($directorio)) {
                mkdir($directorio, 0777, true);
            }

            $nombreTemp = $_FILES["imagen"]["tmp_name"];
            $nombreImagen = $_FILES["imagen"]["name"];


            if (!empty($_FILES["imagen"]["tmp_name"])) {
                move_uploaded_file($nombreTemp, $directorio . urlencode($nombreImagen));
            } else {
                $imagenPorDefecto = "assets/img/usuarios/default.png";
                $destino = $directorio . "default.png";
                copy($imagenPorDefecto, $destino);
                $arrayUser["imagen"]["name"] = "default.png";
            }

            $id = $this->model->insert($arrayUser);

            if ($id !== null) {
                header("Location: index.php");
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

        if ($usuario) {
            $directorio = "assets/img/usuarios/" . $usuario->nombre;
            $this->eliminarCarpeta($directorio);
        }

        $borrado = $this->model->delete($id);
        $redireccion = "location:index.php?accion=buscar&tabla=usuarios";

        if ($borrado == false) $redireccion .=  "&error=true";
        header($redireccion);
        exit();
    }

    function eliminarCarpeta($carpeta)
    {
        if (is_dir($carpeta)) {
            $archivos = array_diff(scandir($carpeta), array('.', '..'));
            foreach ($archivos as $archivo) {
                $ruta = $carpeta . "/" . $archivo;
                is_dir($ruta) ? $this->eliminarCarpeta($ruta) : unlink($ruta);
            }
            return rmdir($carpeta);
        }
        return false;
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
        // Validación de edad
        if (isset($arrayUser["edad"])) {
            $edad = (int)$arrayUser["edad"];
            if ($edad < 12 || $edad > 90) {
                $errores["edad"][] = "La edad debe estar entre 12 y 90 años";
                $error = true;
            }
        }
    
        // Validación de gmail
        if (isset($arrayUser["gmail"])) {
            if (!preg_match('/^[\w\.\-]+@gmail\.com$/', $arrayUser["gmail"])) {
                $errores["gmail"][] = "El gmail debe tener formato válido (@gmail.com)";
                $error = true;
            }
        }
    
        // Validación de teléfono
        if (isset($arrayUser["telefono"])) {
            if (!preg_match('/^\d{9}$/', $arrayUser["telefono"])) {
                $errores["telefono"][] = "El teléfono debe contener exactamente 9 dígitos";
                $error = true;
            }
        }
        //campos NO VACIOS
        $arrayNoNulos = ["nombre", "contrasenya"];
        $nulos = HayNulos($arrayNoNulos, $arrayUser);
        if (count($nulos) > 0) {
            $error = true;
            for ($i = 0; $i < count($nulos); $i++) {
                $errores[$nulos[$i]][] = "El campo {$nulos[$i]} es nulo";
            }
        }

        //CAMPOS UNICOS
        $arrayUnicos = [];
        if ($arrayUser["nombre"] != $arrayUser["nombreOriginal"]) $arrayUnicos[] = "nombre";

        foreach ($arrayUnicos as $CampoUnico) {
            if ($this->model->exists($CampoUnico, $arrayUser[$CampoUnico])) {
                $errores[$CampoUnico][] = "El {$arrayUser[$CampoUnico]} de {$CampoUnico} ya existe";
                $error = true;
            }
        }

        //todo correcto
        $editado = false;
        if (!$error) $editado = $this->model->edit($id, $arrayUser);

        if ($editado) {
            // Si el nombre del usuario ha cambiado, renombrar la carpeta
            if ($arrayUser["nombre"] != $arrayUser["nombreOriginal"]) {
                $directorioAntiguo = "assets/img/usuarios/" . $arrayUser["nombreOriginal"] . "/";
                $directorioNuevo = "assets/img/usuarios/" . $arrayUser["nombre"] . "/";

                if (file_exists($directorioAntiguo)) {
                    rename($directorioAntiguo, $directorioNuevo);
                }

                // Verificar si hay una imagen personalizada y actualizar la referencia
                $imagenActual = $arrayUser["imagen"] ?? "default.png";
                if ($imagenActual !== "default.png") {
                    $arrayUser["imagen"] = $directorioNuevo . basename($imagenActual);
                }
            }

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
