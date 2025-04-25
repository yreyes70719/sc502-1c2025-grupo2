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
// Obtener las adopciones desde el controlador
$url = 'http://localhost/ProyectoAW/app/controllers/AdopcionController.php';
$adopciones = json_decode(file_get_contents($url), true);
?>

<link rel="stylesheet" href="public/css/adopcion_styles.css?v=<?= time() ?>">
<div class="adopcion-container">
    <h2 class="adopcionT">Adopciones: Encuentra un Nuevo Amigo</h2>
    <h3>¡Dale un hogar a quien más lo necesita!</h3>
    <p class="parrafoT">Explora las mascotas disponibles para adopción y
        ayúdanos a darles una segunda oportunidad.</p>

    <a href="?page=agregarAdopcion" class="button agregar-btn">Agregar Nueva Adopción</a>

    <?php if (!empty($adopciones)): ?>
        <?php foreach ($adopciones as $adopcion): ?>
            <div class="reporte">
                <img src="public/uploads/<?= htmlspecialchars($adopcion['foto']) ?>" alt="<?= htmlspecialchars($adopcion['nombre_mascota']) ?>" class="mascota-img-grande">
                <div class="detalles">
                    <p><strong>Nombre:</strong> <?= htmlspecialchars($adopcion['nombre_mascota']) ?></p>
                    <p><strong>Raza:</strong> <?= htmlspecialchars($adopcion['tipo']) ?></p>
                    <p><strong>Edad:</strong> <?= htmlspecialchars($adopcion['edad']) ?> años</p>
                    <p><strong>Tipo:</strong> <?= htmlspecialchars($adopcion['tipo']) ?></p>
                    <p><strong>Estado de salud:</strong> <?= htmlspecialchars($adopcion['estado_salud']) ?></p>
                    <p><strong>Descripción:</strong> <?= htmlspecialchars($adopcion['descripcion']) ?></p>
                    <p><strong>Estado:</strong> 
                        <span class="estado <?= $adopcion['estado'] === 'Disponible' ? 'disponible' : 'adoptado' ?>">
                            <?= htmlspecialchars($adopcion['estado']) ?>
                        </span>
                    </p>
                    <p>Para contactar al dueño de la mascota via mail, 
                        <a href="mailto:<?= htmlspecialchars($adopcion['correo_usuario']) ?>" class="contact-link">
                            pulse aquí
                        </a>.
                    </p>
                    <div class="button-group">
                        <!-- Botón para cambiar el estado -->
                        <button class="button cambiar-estado-btn <?= $adopcion['estado'] === 'Disponible' ? 'btn-adoptado' : 'btn-disponible' ?>" 
                                data-id="<?= $adopcion['id_adopcion'] ?>" 
                                data-estado="<?= $adopcion['estado'] === 'Disponible' ? 'Adoptado' : 'Disponible' ?>">
                            <?= $adopcion['estado'] === 'Disponible' ? 'Marcar como Adoptado' : 'Marcar como Disponible' ?>
                        </button>
                        <!-- Botón para eliminar la adopción -->
                        <button class="button eliminar-btn" data-id="<?= $adopcion['id_adopcion'] ?>">Eliminar</button>
                    </div>
                </div>
                <div class="comentarios">
                    <h4>Comentarios</h4>
                    <ul class="comentarios-list" id="comentarios-<?= $adopcion['id_adopcion'] ?>">
                        <!-- Los comentarios se cargarán dinámicamente con JavaScript -->
                    </ul>
                    <textarea class="comentario-textarea" data-id="<?= $adopcion['id_adopcion'] ?>" placeholder="Añadir un comentario..."></textarea>
                    <button class="agregar-comentario-btn" data-id="<?= $adopcion['id_adopcion'] ?>">Agregar Comentario</button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay mascotas disponibles para adopción en este momento.</p>
    <?php endif; ?>
    <script src="public/js/adopcion_script.js"></script>
</div>
