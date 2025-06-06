<?php
require_once('config/db.php');

class mensajesModel
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = db::conexion();
    }

    public function insert(array $user): ?int
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
            return ($resultado == true) ? $this->conexion->lastInsertId() : null;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<br>";
            return false;
        }
    }

    public function read(int $id): ?array
    {
        $sentencia = $this->conexion->prepare("SELECT * FROM mensajes WHERE id_cliente = :id_cliente");
        $arrayDatos = [":id_cliente" => $id];
        $resultado = $sentencia->execute($arrayDatos);

        if (!$resultado) return [];

        $mensajes = $sentencia->fetchAll(PDO::FETCH_ASSOC); // nota: fetchAll, no fetch
        return $mensajes ?: []; // devuelve un array vacío si no hay resultados
    }

    public function readFisio(int $id): ?array
    {
        $sentencia = $this->conexion->prepare("SELECT * FROM mensajes WHERE id_fisio = :id_fisio");
        $arrayDatos = [":id_fisio" => $id];
        $resultado = $sentencia->execute($arrayDatos);

        if (!$resultado) return [];

        $mensajes = $sentencia->fetchAll(PDO::FETCH_ASSOC); // nota: fetchAll, no fetch
        return $mensajes ?: []; // devuelve un array vacío si no hay resultados
    }

    public function readCalendario(int $id): ?array {
        $stmt = $this->conexion->prepare("SELECT * FROM mensajes WHERE id_fisio = :id_fisio ORDER BY fecha_cita ASC");
        $stmt->execute([":id_fisio" => $id]);
        $mensajes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $mensajes ?: [];
    }

    public function readEdit(int $id): ?stdClass
    {
        $sentencia = $this->conexion->prepare("SELECT * FROM mensajes WHERE id=:id");
        $arrayDatos = [":id" => $id];
        $resultado = $sentencia->execute($arrayDatos);
        // ojo devuelve true si la consulta se ejecuta correctamente
        // eso no quiere decir que hayan resultados
        if (!$resultado) return null;
        //como sólo va a devolver un resultado uso fetch
        // DE Paso probamos el FETCH_OBJ
        $mensaje = $sentencia->fetch(PDO::FETCH_OBJ);
        //fetch duevelve el objeto stardar o false si no hay persona
        return ($mensaje == false) ? null : $mensaje;
    }

    public function readAll(): array
    {
        $sentencia = $this->conexion->prepare("SELECT * FROM mensajes;");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_OBJ);
    }

    public function delete(int $id): bool
    {
        try {
            $sentencia = $this->conexion->prepare("DELETE FROM mensajes WHERE id = :id");
            $sentencia->execute([":id" => $id]);
            return $sentencia->rowCount() > 0;
        } catch (Exception $e) {
            echo 'Excepción capturada: ', $e->getMessage(), "<br>";
            return false;
        }
    }

    public function edit(int $idAntiguo, array $arrayMensaje): bool
    {
        try {
            $sql = "UPDATE mensajes SET id_cliente = :id_cliente, nombre_cliente = :nombre_cliente, titulo_cita = :titulo_cita, descripcion = :descripcion,
            zona_dolorida = :zona_dolorida, fecha_cita = :fecha_cita, id_fisio = :id_fisio, estado = :estado ";
            $sql .= " WHERE id = :id;";
            $arrayDatos = [
                ":id" => $idAntiguo,
                ":id_cliente" => $arrayMensaje["id_cliente"],
                ":nombre_cliente" => $arrayMensaje["nombre_cliente"],
                ":titulo_cita" => $arrayMensaje["titulo_cita"],
                ":descripcion" => $arrayMensaje["descripcion"],
                ":zona_dolorida" => $arrayMensaje["zona_dolorida"],
                ":fecha_cita" => $arrayMensaje["fecha_cita"],
                ":id_fisio" => $arrayMensaje["id_fisio"],
                ":estado" => $arrayMensaje["estado"],
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
        $sql = "SELECT * FROM mensajes WHERE $campo LIKE :nombre";
        $arrayDatos = [];

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
                $sql = "SELECT * FROM mensajes WHERE $campo NOT LIKE :nombre";
                $arrayDatos = [":nombre" => "$usuario"];
                break;
            default:
                $arrayDatos = [":nombre" => $usuario];
                break;
        }

        $sentencia = $this->conexion->prepare($sql);
        $sentencia->execute($arrayDatos);
        return $sentencia->fetchAll(PDO::FETCH_OBJ);
    }

    public function exists(string $campo, string $valor): bool
    {
        $sentencia = $this->conexion->prepare("SELECT * FROM mensajes WHERE $campo=:valor");
        $sentencia->execute([":valor" => $valor]);
        return $sentencia->rowCount() > 0;
    } 
}
