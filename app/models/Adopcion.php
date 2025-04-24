<?php
require_once '../../config/database.php';

class Adopcion
{
    public static function getAll(): array
    {
        global $conn;

        try {
            $sql = "SELECT * FROM Adopciones";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                return $result->fetch_all(MYSQLI_ASSOC);
            } else {
                return [];
            }
        } catch (mysqli_sql_exception $e) {
            return ["error" => "Error al obtener adopciones: " . $e->getMessage()];
        }
    }

    public static function add($nombre_mascota, $tipo, $edad, $estado_salud, $foto, $descripcion, $id_usuario)
    {
        global $conn;

        $sql = "INSERT INTO Adopciones (nombre_mascota, tipo, edad, estado_salud, foto, descripcion, id_usuario) 
                VALUES ('$nombre_mascota', '$tipo', $edad, '$estado_salud', '$foto', '$descripcion', $id_usuario)";

        if ($conn->query($sql) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function delete($id_adopcion)
    {
        global $conn;

        $sql = "DELETE FROM Adopciones WHERE id_adopcion = $id_adopcion";

        if ($conn->query($sql) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function updateHealthStatus($id_adopcion, $estado_salud)
    {
        global $conn;

        $sql = "UPDATE Adopciones SET estado_salud = '$estado_salud' WHERE id_adopcion = $id_adopcion";

        if ($conn->query($sql) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }
}
?>
