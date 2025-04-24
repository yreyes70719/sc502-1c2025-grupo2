<!-- filepath: d:\Programs\xampp\htdocs\ProyectoAW\views\layout.php -->
<?php
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 'home';

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
        <link rel="stylesheet" href="public/css/navbar_styles.css">
        <link rel="stylesheet" href="public/css/home_styles.css">

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
                        <li><a href="?page=chats" class="<?= $currentPage === 'chats' ? 'active' : '' ?>">Chats</a></li>
                        <li><a href="?page=perfil" class="<?= $currentPage === 'perfil' ? 'active' : '' ?>">Perfil</a></li>
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
<?php endif; ?>