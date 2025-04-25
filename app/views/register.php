<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$error_message = $_SESSION['error_message'] ?? '';
unset($_SESSION['error_message']); // Limpiar el mensaje después de mostrarlo
?>

<link rel="stylesheet" href="public/css/register_styles.css?v=<?= time() ?>">

<div class="app-title">
    <img src="public/images/Paw.png" alt="PawFinder Logo" class="logo">
    <h1>PawFinder</h1>
    <img src="public/images/Paw.png" alt="PawFinder Logo" class="logo">
</div>
<div class="register-container">
    <h2>Registro de Usuario</h2>
    <form action="app/controllers/RegisterController.php" method="POST">
        <label for="userName">Nombre de Usuario:</label>
        <input type="text" id="userName" name="userName" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" required>
        
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        
        <label for="confirm-password">Confirmar Contraseña:</label>
        <input type="password" id="confirm-password" name="confirm-password" required>
        
        <button type="submit">Registrarse</button>
    </form>
    <p>¿Ya tienes una cuenta? <a href="?page=login">Inicia sesión aquí</a></p>
    <hr>
    <p><a href="?page=home" class="volver-btn">Volver al Inicio</a></p>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (!empty($error_message)): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '<?= htmlspecialchars($error_message) ?>',
            confirmButtonText: 'Aceptar'
        });
    </script>
<?php endif; ?>
