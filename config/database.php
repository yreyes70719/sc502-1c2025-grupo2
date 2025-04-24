<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "PawFinderBD";

try {
    $conn = new mysqli($host, $user, $password, $database);
    if ($conn->connect_error) {
        throw new Exception("Error de conexión: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die($e->getMessage());
}
?>