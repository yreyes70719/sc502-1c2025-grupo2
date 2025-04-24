<link rel="stylesheet" href="public/css/login_styles.css">

<div class="app-title">
    <img src="public/images/Paw.png" alt="PawFinder Logo" class="logo">
    <h1>PawFinder</h1>
    <img src="public/images/Paw.png" alt="PawFinder Logo" class="logo">
</div>
<div class="login-container">
    <h2>Inicio de Sesión</h2>
    <form onsubmit="redirectToHome(event)">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit">Iniciar Sesión</button>
    </form>
    <p>¿No tienes una cuenta? <a href="?page=register">Regístrate aquí</a></p>
    <p><a href="">¿Olvidaste tu contraseña?</a></p> <!-- Enlace de recuperar contraseña -->
</div>
