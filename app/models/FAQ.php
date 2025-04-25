<?php
require_once __DIR__ . '/../../config/database.php';

class FAQ
{
    public static function getAll(): array
    {
        global $conn;

        try {
            $sql = "SELECT * FROM FAQ";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                return $result->fetch_all(MYSQLI_ASSOC);
            } else {
                return [];
            }
        } catch (mysqli_sql_exception $e) {
            return ["error" => "Error al obtener preguntas frecuentes: " . $e->getMessage()];
        }
    }

    public static function add($pregunta, $respuesta)
    {
        global $conn;

        $sql = "INSERT INTO FAQ (pregunta, respuesta) VALUES ('$pregunta', '$respuesta')";

        if ($conn->query($sql) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function delete($id_faq)
    {
        global $conn;

        $sql = "DELETE FROM FAQ WHERE id_faq = $id_faq";

        if ($conn->query($sql) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }
}
?>