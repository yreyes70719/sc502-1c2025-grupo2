<?php
require_once __DIR__ . '/../models/FAQ.php';
session_start(); // Asegúrate de que la sesión esté iniciada
$faqs = FAQ::getAll();

// Obtener el rol del usuario autenticado
$usuario_actual = $_SESSION['usuario'] ?? null;
$rol_usuario = $usuario_actual['rol'] ?? '';
?>

<link rel="stylesheet" href="public/css/soporte_styles.css?v=<?= time() ?>">

<div class="soporte-container">
    <h2 class="tituloSoporte">Soporte</h2>
    <p class="parrafoT">Bienvenido a nuestra sección de soporte. Si tienes alguna duda o problema con la plataforma, aquí encontrarás respuestas y asistencia.</p>
    <hr class="divisor">

    <section class="faq">
        <h3 class="titulo-destacados">Preguntas Frecuentes (FAQ)</h3>
        <table class="faq-table">
            <thead>
                <tr>
                    <th>Pregunta</th>
                    <th>Respuesta</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($faqs) && !isset($faqs['error'])): ?>
                    <?php foreach ($faqs as $faq): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($faq['pregunta']) ?></strong></td>
                            <td><?= htmlspecialchars($faq['respuesta']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2" class="text-center">No hay preguntas frecuentes registradas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <hr class="divisor">

    <section class="contact-form">
        <h3 class="titulo-destacados">Formulario de Reporte (Problemas/Dudas)</h3>
        
        <!-- Contenedor para mensajes de confirmación -->
        <div id="successMessage" class="hidden success-message">
            <p>Duda enviada correctamente.</p>
        </div>
        <div id="errorMessage" class="hidden error-message">
            <p>Ocurrió un error al enviar la duda. Por favor, inténtalo de nuevo.</p>
        </div>

        <form id="dudasForm">
            <input type="hidden" name="action" value="add"> <!-- Acción para agregar una duda -->
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>

            <div class="form-group">
                <label for="correo">Email:</label>
                <input type="email" id="correo" name="correo" required>
            </div>

            <div class="form-group">
                <label for="mensaje">Reporte:</label>
                <textarea id="mensaje" name="mensaje" required></textarea>
            </div>

            <button type="submit" id="add-duda">Enviar</button>
        </form>
    </section>

    <hr class="divisor">

    <section class="soporteEmail">
        <h3 class="titulo-destacados">Correo de Soporte</h3>
        <p class="parrafoT">Para asistencia inmediata envíanos un correo a <a href="mailto:soportepawfinder@outlook.com">soportepawfinder@outlook.com</a>.</p>
        <p class="diagonal">Incluye tu nombre y una descripción clara del problema para una mejor asistencia.</p>
    </section>
</div>
<script src="public/js/soporte_script.js?v=<?= time() ?>"></script>
