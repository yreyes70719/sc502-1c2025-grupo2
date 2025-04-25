<?php
session_start();
$currentPage = isset($_GET['page']) ? $_GET['page'] : 'home';

// Páginas protegidas que requieren sesión activa
$protectedPages = ['perfil', 'chats', 'reportes', 'adopcion', 'dudas'];

// Si el usuario intenta acceder a una página protegida sin sesión, redirigir al login
if (in_array($currentPage, $protectedPages) && !isset($_SESSION['id_usuario'])) {
    header("Location: ?page=login");
    exit;
}

// Páginas que deben ignorar el layout
$excludeLayout = ['register', 'login'];

if (!in_array($currentPage, $excludeLayout)) :
?>
<!DOCTYPE html> 
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Página Principal</title>
        <!-- Estilos generales -->
        <link rel="stylesheet" href="public/css/navbar_styles.css?v=<?= time() ?>">
        <link rel="stylesheet" href="public/css/home_styles.css?v=<?= time() ?>">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="public/js/script.js"></script>
    </head>
    <body>
        <header>
            <div class="navbarPaw">
                <img src="public/images/Paw.png" alt="PawFinder Logo" class="logoPaw">
                <h1>PawFinder</h1>
                <nav>
                    <ul>
                        <li><a href="?page=home" class="<?= $currentPage === 'home' ? 'active' : '' ?>">Inicio</a></li>
                        <li><a href="?page=reportes" class="<?= $currentPage === 'reportes' ? 'active' : '' ?>">Reportes</a></li>
                        <li><a href="?page=adopcion" class="<?= $currentPage === 'adopcion' ? 'active' : '' ?>">Adopción</a></li>
                        <li><a href="?page=soporte" class="<?= $currentPage === 'soporte' ? 'active' : '' ?>">Soporte</a></li>
                        <li><a href="?page=recursos" class="<?= $currentPage === 'recursos' ? 'active' : '' ?>">Recursos</a></li>
                        <li><a href="?page=dudas" class="<?= $currentPage === 'dudas' ? 'active' : '' ?>">Dudas</a></li>
                        <li><a href="?page=perfil" class="<?= $currentPage === 'perfil' ? 'active' : '' ?>">Perfil</a></li>
                        
                        <!-- Opciones de sesión -->
                        <li class="session-box">
                            <?php if (isset($_SESSION['id_usuario'])): ?>
                                <div class="session-info">
                                    <span>Bienvenido, <?= htmlspecialchars($_SESSION['nombre_usuario']); ?></span>
                                    <a href="app/controllers/LogoutController.php" class="logout-btn">Cerrar Sesión</a>
                                </div>
                            <?php else: ?>
                                <div class="session-info">
                                    <a href="?page=login" class="login-btn">Iniciar Sesión</a>
                                </div>
                            <?php endif; ?>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="content">
<?php endif; ?>

            <?php
                // Cargar contenido dinámico basado en la página seleccionada
                $file = __DIR__ . "/$currentPage.php";

                if (file_exists($file)) {
                    include $file;
                } else {
                    echo "<h2>Página no encontrada</h2>";
                }
            ?>

<?php if (!in_array($currentPage, $excludeLayout)) : ?>
        </div>

        <footer class="footer">
            <p>&copy; PawFinder 2025. Todos los derechos reservados.</p>
        </footer>

        
    </body>
</html>
<?php endif; ?><?php if (isset($_SESSION['success_message'])): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '<?= htmlspecialchars($_SESSION['success_message']) ?>',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
    <?php unset($_SESSION['success_message']); // Eliminar el mensaje después de mostrarlo ?>
<?php endif; ?>