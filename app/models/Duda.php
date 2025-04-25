<?php
require_once __DIR__ . '/../../config/database.php';

class Duda
{
    public static function getAll(): array
    {
        global $conn;

        try {
            $sql = "SELECT * FROM Dudas";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                return $result->fetch_all(MYSQLI_ASSOC);
            } else {
                return [];
            }
        } catch (mysqli_sql_exception $e) {
            return ["error" => "Error al obtener dudas: " . $e->getMessage()];
        }
    }

    public static function add($nombre, $correo, $mensaje)
    {
        global $conn;

        $sql = "INSERT INTO Dudas (nombre, correo, mensaje) VALUES ('$nombre', '$correo', '$mensaje')";

        if ($conn->query($sql) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function delete($id_duda)
    {
        global $conn;

        $sql = "DELETE FROM Dudas WHERE id_duda = $id_duda";

        if ($conn->query($sql) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }
}
?>