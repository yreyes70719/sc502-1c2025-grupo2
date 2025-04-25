<?php
session_start();
if (isset($_SESSION['success_message'])) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '¡Éxito!',
                text: '" . $_SESSION['success_message'] . "',
                icon: 'success',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#4CAF50'
            });
        });
    </script>";
    unset($_SESSION['success_message']); // Eliminar el mensaje después de mostrarlo
}
?>

<?php
// Obtener los reportes desde el controlador
$url = 'http://localhost/ProyectoAW/app/controllers/ReportesController.php';
$reportes = json_decode(file_get_contents($url), true);
?>

<link rel="stylesheet" href="public/css/reportes_styles.css?v=<?= time() ?>">
<div class="reportes-container">
    <h2 class="reportesT">Reportes de Mascotas Perdidas y Encontradas</h2>
    <h3>¡Ayudemos a reunir familias!</h3>
    <p class="parrafoT">Si has perdido o encontrado una mascota, publica un reporte con los detalles para que la comunidad pueda ayudarte.</p>

    <a href="?page=agregarReporte" class="button agregar-btn">Agregar Nuevo Reporte</a>

    <?php if (!empty($reportes)): ?>
        <?php foreach ($reportes as $reporte): ?>
            <div class="reporte">
                <img src="public/uploads/<?= htmlspecialchars($reporte['imagen']) ?>" alt="<?= htmlspecialchars($reporte['nombre_mascota']) ?>" class="mascota-img-grande">
                <div class="detalles">
                    <p><strong>Nombre:</strong> <?= htmlspecialchars($reporte['nombre_mascota']) ?></p>
                    <p><strong>Raza:</strong> <?= htmlspecialchars($reporte['raza']) ?></p>
                    <p><strong>Edad:</strong> <?= htmlspecialchars($reporte['edad']) ?> años</p>
                    <p><strong>Ubicación:</strong> <?= htmlspecialchars($reporte['ubicacion']) ?></p>
                    <p><strong>Número del Dueño:</strong> <a href="tel:<?= htmlspecialchars($reporte['numero_dueno']) ?>"><?= htmlspecialchars($reporte['numero_dueno']) ?></a></p>
                    <p><strong>Detalles:</strong> <?= htmlspecialchars($reporte['detalles']) ?></p>
                    <p><strong>Estado:</strong> 
                        <span class="estado <?= $reporte['estado'] === 'Encontrado' ? 'encontrado' : 'desaparecido' ?>">
                            <?= htmlspecialchars($reporte['estado']) ?>
                        </span>
                    </p>
                    <p>Para contactar al dueño de la mascota via mail, 
                        <a href="mailto:<?= htmlspecialchars($reporte['correo_usuario']) ?>" class="contact-link">
                            pulse aquí
                        </a>.
                    </p>
                    <div class="button-group">
                        <!-- Botón para cambiar el estado -->
                        <button class="button cambiar-estado-btn <?= $reporte['estado'] === 'Desaparecido' ? 'btn-encontrado' : 'eliminar-btn' ?>" 
                                data-id="<?= $reporte['id_reporte'] ?>" 
                                data-estado="<?= $reporte['estado'] === 'Desaparecido' ? 'Encontrado' : 'Desaparecido' ?>">
                            <?= $reporte['estado'] === 'Desaparecido' ? 'Marcar como Encontrado' : 'Marcar como Desaparecido' ?>
                        </button>
                        <!-- Botón para eliminar el reporte -->
                        <button class="button eliminar-btn" data-id="<?= $reporte['id_reporte'] ?>">Eliminar</button>
                    </div>
                </div>
                <div class="comentarios">
                    <h4>Comentarios</h4>
                    <ul class="comentarios-list" id="comentarios-<?= $reporte['id_reporte'] ?>">
                        <!-- Los comentarios se cargarán dinámicamente con JavaScript -->
                    </ul>
                    <textarea class="comentario-textarea" data-id="<?= $reporte['id_reporte'] ?>" placeholder="Añadir un comentario..."></textarea>
                    <button class="agregar-comentario-btn" data-id="<?= $reporte['id_reporte'] ?>">Agregar Comentario</button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay reportes de mascotas en este momento.</p>
    <?php endif; ?>
    <script src="public/js/reporte_script.js"></script>
</div>
