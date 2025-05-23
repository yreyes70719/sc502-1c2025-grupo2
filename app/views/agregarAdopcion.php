<?php
session_start();
?>

<link rel="stylesheet" href="public/css/adopcion_styles.css?v=<?= time() ?>">

<div class="form-container">
    <h2 class="adopcionT">Publicar Mascota en Adopción</h2>
    <h3>¡Dale un hogar a quien más lo necesita!</h3>
    <p class="parrafoT">Publica una mascota en adopción con los detalles para que la comunidad pueda ayudar a encontrarle un hogar.</p>
    <form id="formAdopcion" action="/ProyectoAW/app/controllers/AdopcionController.php" method="POST" enctype="multipart/form-data" onsubmit="return handleFormSubmit(event)">
        <!-- Campo oculto para la acción -->
        <input type="hidden" name="action" value="add">

        <label for="nombre">Nombre de la mascota:</label>
        <input type="text" id="nombre" name="nombre_mascota" required>

        <label for="tipo">Tipo (Perro, Gato, etc.):</label>
        <input type="text" id="tipo" name="tipo" required>

        <label for="edad">Edad:</label> 
        <input type="number" id="edad" name="edad" required>

        <label for="estado">Estado de salud:</label>
        <input type="text" id="estado" name="estado_salud" required>

        <label for="foto">Foto:</label>
        <input type="file" id="foto" name="foto" accept="image/*" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required></textarea>

        <!-- Campo oculto para el ID del usuario -->
        <input type="hidden" name="id_usuario" value="<?= $_SESSION['id_usuario'] ?? '' ?>">

        <button type="submit">Publicar</button>
        <button type="button" onclick="window.location.href='?page=adopcion'">Volver Atrás</button>
    </form>
</div>

<script src="public/js/adopcion_script.js"></script>