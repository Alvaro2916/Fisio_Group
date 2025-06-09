<?php
require_once('config/db.php');

class usuariosModel
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = db::conexion();
    }

    public function insert(array $user): ?int //devuelve entero o null
    {
        try {
            $sql = "INSERT INTO usuarios(nombre, apellidos, telefono, edad, imagen, descripcion, gmail, permisos, contrasenya)  
            VALUES (:nombre, :apellidos, :telefono, :edad, :imagen, :descripcion, :gmail, :permisos, :contrasenya);";
            $sentencia = $this->conexion->prepare($sql);
            $arrayDatos = [
                ":nombre" => $user["nombre"],
                ":apellidos" => $user["apellidos"],
                ":telefono" => $user["telefono"],
                ":edad" => $user["edad"],
                ":imagen" => $user["imagen"]["name"],
                ":descripcion" => $user["descripcion"],
                ":gmail" => $user["gmail"],
                ":permisos" => $user["permisos"] ?? 0,
                ":contrasenya" => password_hash($user["contrasenya"], PASSWORD_DEFAULT),
            ];
            $resultado = $sentencia->execute($arrayDatos);

            /*Pasar en el mismo orden de los ? execute devuelve un booleano. 
            True en caso de que todo vaya bien, falso en caso contrario.*/
            //Así podriamos evaluar
            return ($resultado == true) ? $this->conexion->lastInsertId() : null;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<bR>";
            return false;
        }
    }

    public function read(int $id): ?stdClass
    {
        $sentencia = $this->conexion->prepare("SELECT * FROM usuarios WHERE id=:id");
        $arrayDatos = [":id" => $id];
        $resultado = $sentencia->execute($arrayDatos);
        // ojo devuelve true si la consulta se ejecuta correctamente
        // eso no quiere decir que hayan resultados
        if (!$resultado) return null;
        //como sólo va a devolver un resultado uso fetch
        // DE Paso probamos el FETCH_OBJ
        $user = $sentencia->fetch(PDO::FETCH_OBJ);
        //fetch duevelve el objeto stardar o false si no hay persona
        return ($user == false) ? null : $user;
    }

    public function readAll(): array
    {
        $sentencia = $this->conexion->prepare("SELECT * FROM usuarios;");
        $resultado = $sentencia->execute();
        $usuarios = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $usuarios;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM usuarios WHERE id =:id";
        try {
            $sentencia = $this->conexion->prepare($sql);
            //devuelve true si se borra correctamente
            //false si falla el borrado
            $resultado = $sentencia->execute([":id" => $id]);
            return ($sentencia->rowCount() <= 0) ? false : true;
        } catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "<bR>";
            return false;
        }
    }

    public function edit(int $idAntiguo, array $arrayUsuario): bool
    {
        try {
            $contrasenya = $arrayUsuario["contrasenya"];
            if (!password_get_info($contrasenya)['algo']) {
                $contrasenya = password_hash($contrasenya, PASSWORD_DEFAULT);
            }

            $sql = "UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, telefono = :telefono,
            edad = :edad, gmail = :gmail, contrasenya = :contrasenya WHERE id = :id;";

            $arrayDatos = [
                ":id" => $idAntiguo,
                ":nombre" => $arrayUsuario["nombre"],
                ":apellidos" => $arrayUsuario["apellidos"],
                ":telefono" => $arrayUsuario["telefono"],
                ":edad" => $arrayUsuario["edad"],
                ":gmail" => $arrayUsuario["gmail"],
                ":contrasenya" => $contrasenya,
            ];
            $sentencia = $this->conexion->prepare($sql);
            return $sentencia->execute($arrayDatos);
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<br>";
            return false;
        }
    }

    public function search(string $campo, string $modo, string $usuario): array
    {
        $sentencia = $this->conexion->prepare("SELECT * FROM usuarios WHERE $campo LIKE :nombre");
        //ojo el si ponemos % siempre en comillas dobles "
        switch ($modo) {
            case 'empieza':
                $arrayDatos = [":nombre" => "$usuario%"];
                break;

            case 'acaba':
                $arrayDatos = [":nombre" => "%$usuario"];
                break;

            case 'contiene':
                $arrayDatos = [":nombre" => "%$usuario%"];
                break;
            
            case 'distinto':
                $sentencia = $this->conexion->prepare("SELECT * FROM usuarios WHERE $campo NOT LIKE :nombre");
                $arrayDatos = [":nombre" => "$usuario"];
                break;

            default:
                $arrayDatos = [":nombre" => $usuario];
                break;
        }

        $resultado = $sentencia->execute($arrayDatos);
        if (!$resultado) return [];
        $usuarios = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $usuarios;
    }

    public function login(string $nombre, string $contrasenya): ?stdClass
    {
        $sentencia = $this->conexion->prepare("SELECT * FROM usuarios WHERE nombre=:nombre");
        $arrayDatos = [
            ":nombre" => $nombre,
        ];
        $resultado = $sentencia->execute($arrayDatos);
        if (!$resultado) return null;
        $user = $sentencia->fetch(PDO::FETCH_OBJ);
        //fetch duevelve el objeto stardar o false si no hay persona
        return ($user == false || !password_verify($contrasenya, $user->contrasenya)) ? null : $user;
    }

    public function exists(string $campo, string $valor): bool
    {
        $sentencia = $this->conexion->prepare("SELECT * FROM usuarios WHERE $campo=:valor");
        $arrayDatos = [":valor" => $valor];
        $resultado = $sentencia->execute($arrayDatos);
        return (!$resultado || $sentencia->rowCount() <= 0) ? false : true;
    }
}
