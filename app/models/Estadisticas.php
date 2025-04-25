<?php
require_once __DIR__ . '/../../config/database.php';

class Estadisticas
{
    public static function getMascotasEncontradas()
    {
        global $conn;

        $sql = "SELECT COUNT(*) AS total FROM Reportes WHERE estado = 'Encontrado'";
        $result = $conn->query($sql);

        if ($result && $row = $result->fetch_assoc()) {
            return $row['total'];
        }

        return 0;
    }

    public static function getAdopcionesRealizadas()
    {
        global $conn;

        $sql = "SELECT COUNT(*) AS total FROM Adopciones WHERE estado = 'Adoptado'";
        $result = $conn->query($sql);

        if ($result && $row = $result->fetch_assoc()) {
            return $row['total'];
        }

        return 0;
    }
}
?>