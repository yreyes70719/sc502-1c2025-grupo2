<link rel="stylesheet" href="public/css/login_styles.css?v=<?= time() ?>">

<div class="app-title">
    <img src="public/images/Paw.png" alt="PawFinder Logo" class="logo">
    <h1>PawFinder</h1>
    <img src="public/images/Paw.png" alt="PawFinder Logo" class="logo">
</div>
<div class="login-container">
    <h2>Inicio de Sesión</h2>
    <form action="app/controllers/LoginController.php" method="POST">
        <label for="correo">Email:</label>
        <input type="email" id="correo" name="correo" required>
        
        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required>
        
        <button type="submit">Iniciar Sesión</button>
    </form>
    <p>¿No tienes una cuenta? <a href="?page=register">Regístrate aquí</a></p>
    <p><a href="?page=forgot_password">¿Olvidaste tu contraseña?</a></p> <!-- Enlace de recuperar contraseña -->
    <hr>
    <p><a href="?page=home" class="volver-btn">Volver al Inicio</a></p>
</div>
