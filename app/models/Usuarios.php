<?php
require_once '../../config/database.php';

class Usuario
{
    public static function getAll(): array
    {
        global $conn;

        try {
            $sql = "SELECT * FROM Usuarios";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                return $result->fetch_all(MYSQLI_ASSOC);
            } else {
                return [];
            }
        } catch (mysqli_sql_exception $e) {
            return ["error" => "Error al obtener usuarios: " . $e->getMessage()];
        }
    }

    public static function add($nombre_usuario, $correo, $telefono, $contraseña, $foto_perfil, $rol = 'Usuario')
    {
        global $conn;

        $hashed_password = password_hash($contraseña, PASSWORD_BCRYPT);

        $sql = "INSERT INTO Usuarios (nombre_usuario, correo, telefono, contraseña, foto_perfil, rol) 
                VALUES ('$nombre_usuario', '$correo', '$telefono', '$hashed_password', '$foto_perfil', '$rol')";

        if ($conn->query($sql) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function delete($id_usuario)
    {
        global $conn;

        $sql = "DELETE FROM Usuarios WHERE id_usuario = $id_usuario";

        if ($conn->query($sql) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function updateRole($id_usuario, $rol)
    {
        global $conn;

        $sql = "UPDATE Usuarios SET rol = '$rol' WHERE id_usuario = $id_usuario";

        if ($conn->query($sql) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function updatePhone($id_usuario, $telefono)
    {
        global $conn;

        $sql = "UPDATE Usuarios SET telefono = '$telefono' WHERE id_usuario = $id_usuario";

        if ($conn->query($sql) === TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function authenticate($correo, $contraseña)
    {
        global $conn;

        $sql = "SELECT * FROM Usuarios WHERE correo = '$correo'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($contraseña, $user['contraseña'])) {
                return $user;
            } else {
                return ["error" => "Contraseña incorrecta"];
            }
        } else {
            return ["error" => "Usuario no encontrado"];
        }
    }

    public static function getById($id_usuario)
    {
        global $conn;

        $sql = "SELECT id_usuario, nombre_usuario, correo, telefono, foto_perfil FROM Usuarios WHERE id_usuario = $id_usuario";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return ["error" => "Usuario no encontrado"];
        }
    }

    public static function updateProfile($id_usuario, $nombre, $telefono, $contrasena = null, $foto_perfil = null)
    {
        global $conn;

        $sql = "UPDATE Usuarios SET nombre_usuario = '$nombre', telefono = '$telefono'";
        
        // Si se proporciona una nueva contraseña, actualízala
        if (!empty($contrasena)) {
            $hashed_password = password_hash($contrasena, PASSWORD_BCRYPT);
            $sql .= ", contraseña = '$hashed_password'";
        }

        // Si se proporciona una nueva foto de perfil, actualízala
        if (!empty($foto_perfil)) {
            $sql .= ", foto_perfil = '$foto_perfil'";
        }

        $sql .= " WHERE id_usuario = $id_usuario";

        if ($conn->query($sql) === TRUE) {
            return ["success" => "Perfil actualizado correctamente", "foto_perfil" => $foto_perfil];
        } else {
            return ["error" => "Error al actualizar el perfil: " . $conn->error];
        }
    }
}
?>