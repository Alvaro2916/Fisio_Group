<?php
require_once('config/db.php');

class UsuariosModel
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = db::conexion();
    }

    public function insert(array $user): ?int //devuelve entero o null
    {
        try {
            $sql = "INSERT INTO usuarios(nombre, imagen, partidas_ganadas, partidas_perdidas, partidas_totales, permisos, contrasenya, digi_evu)  
            VALUES (:nombre, :imagen, :partidas_ganadas, :partidas_perdidas, :partidas_totales, :permisos, :contrasenya, :digi_evu);";
            $sentencia = $this->conexion->prepare($sql);
            $arrayDatos = [
                ":nombre" => $user["nombre"],
                ":imagen" => $user["imagen"]["name"],
                ":partidas_ganadas" => $user["partidas_ganadas"],
                ":partidas_perdidas" => $user["partidas_perdidas"],
                ":partidas_totales" => $user["partidas_totales"],
                ":permisos" => $user["permisos"],
                ":contrasenya" => password_hash($user["contrasenya"], PASSWORD_DEFAULT),
                ":digi_evu" => $user["digi_evu"],
            ];
            $resultado = $sentencia->execute($arrayDatos);

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
        if (!$resultado) return null;
        $user = $sentencia->fetch(PDO::FETCH_OBJ);
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
            $sql = "UPDATE usuarios SET nombre = :nombre, partidas_ganadas = :partidas_ganadas, 
            partidas_perdidas = :partidas_perdidas, partidas_totales = :partidas_totales, permisos = :permisos, 
            contrasenya = :contrasenya, digi_evu = :digi_evu ";
            $sql .= " WHERE id = :id;";
            $arrayDatos = [
                ":id" => $idAntiguo,
                ":nombre" => $arrayUsuario["nombre"],
                ":partidas_ganadas" => $arrayUsuario["partidas_ganadas"],
                ":partidas_perdidas" => $arrayUsuario["partidas_perdidas"],
                ":partidas_totales" => $arrayUsuario["partidas_totales"],
                ":permisos" => $arrayUsuario["permisos"],
                ":contrasenya" => password_hash($arrayUsuario["contrasenya"], PASSWORD_DEFAULT),
                ":digi_evu" => $arrayUsuario["digi_evu"],
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
