<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$error_message = $_SESSION['error_message'] ?? '';
unset($_SESSION['error_message']); // Limpiar el mensaje después de mostrarlo
?>

<link rel="stylesheet" href="/ProyectoAW/public/css/login_styles.css?v=<?= time() ?>">

<div class="app-title">
    <img src="/ProyectoAW/public/images/Paw.png" alt="PawFinder Logo" class="logo">
    <h1>PawFinder</h1>
    <img src="/ProyectoAW/public/images/Paw.png" alt="PawFinder Logo" class="logo">
</div>
<div class="login-container">
    <h2>Inicio de Sesión</h2>
    <form action="/ProyectoAW/app/controllers/LoginController.php" method="POST">
        <label for="correo">Email:</label>
        <input type="email" id="correo" name="correo" required>
        
        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required>
        
        <button type="submit">Iniciar Sesión</button>
    </form>
    <p>¿No tienes una cuenta? <a href="?page=register">Regístrate aquí</a></p>
    <p><a href="?page=forgot_password">¿Olvidaste tu contraseña?</a></p>
    <hr>
    <p><a href="?page=home" class="volver-btn">Volver al Inicio</a></p>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</div>

<?php if (!empty($error_message)): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '<?php echo $error_message; ?>',
            confirmButtonText: 'Aceptar'
        });
    </script>
<?php endif; ?>
