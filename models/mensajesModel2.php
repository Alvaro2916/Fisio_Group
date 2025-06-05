<?php
require_once('config/db.php');

class mensajesModel
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = db::conexion();
    }

    public function insert(array $user): ?int //devuelve entero o null
    {
        try {
            $sql = "INSERT INTO mensajes(id_cliente, nombre_cliente, titulo_cita, descripcion, zona_dolorida, fecha_cita, id_fisio, estado)  
            VALUES (:id_cliente, :nombre_cliente, :titulo_cita, :descripcion, :zona_dolorida, :fecha_cita, :id_fisio, :estado);";
            $sentencia = $this->conexion->prepare($sql);
            $arrayDatos = [
                ":id_cliente" => $user["id_cliente"],
                ":nombre_cliente" => $user["nombre_cliente"],
                ":titulo_cita" => $user["titulo_cita"],
                ":descripcion" => $user["descripcion"],
                ":zona_dolorida" => $user["zona_dolorida"],
                ":fecha_cita" => $user["fecha_cita"],
                ":id_fisio" => $user["id_fisio"],
                ":estado" => $user["estado"],
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
        $sentencia = $this->conexion->prepare("SELECT * FROM mensajes WHERE id=:id");
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
        $sentencia = $this->conexion->prepare("SELECT * FROM mensajes;");
        $resultado = $sentencia->execute();
        $usuarios = $sentencia->fetchAll(PDO::FETCH_OBJ);
        return $usuarios;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM mensajes WHERE id =:id";
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
            $sql = "UPDATE mensajes SET estado = :estado";
            $sql .= " WHERE id = :id;";
            $arrayDatos = [
                ":id" => $idAntiguo,
                ":estado" => $arrayUsuario["estado"],
            ];
            $sentencia = $this->conexion->prepare($sql);
            return $sentencia->execute($arrayDatos);
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<bR>";
            return false;
        }
    }

    public function search(string $campo, string $modo, string $usuario): array
    {
        $sentencia = $this->conexion->prepare("SELECT * FROM mensajes WHERE $campo LIKE :nombre");
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
                $sentencia = $this->conexion->prepare("SELECT * FROM mensajes WHERE $campo NOT LIKE :nombre");
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
        $sentencia = $this->conexion->prepare("SELECT * FROM mensajes WHERE nombre=:nombre");
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
        $sentencia = $this->conexion->prepare("SELECT * FROM mensajes WHERE $campo=:valor");
        $arrayDatos = [":valor" => $valor];
        $resultado = $sentencia->execute($arrayDatos);
        return (!$resultado || $sentencia->rowCount() <= 0) ? false : true;
    }
}
