<?php
session_start();
?>

<link rel="stylesheet" href="public/css/reportes_styles.css?v=<?= time() ?>">

<div class="form-container">
    <h2 class="reportesT">Agrega un Nuevo Reporte</h2>
    <h3>¡Ayudemos a reunir familias!</h3>
    <p class="parrafoT">Si has perdido o encontrado una mascota, publica un reporte con los detalles para que la comunidad pueda ayudarte.</p>
    <form id="formReporte" action="/ProyectoAW/app/controllers/ReportesController.php" method="POST" enctype="multipart/form-data" onsubmit="return handleFormSubmit(event)">
        <!-- Campo oculto para la acción -->
        <input type="hidden" name="action" value="add">

        <label for="nombre">Nombre de la mascota:</label>
        <input type="text" id="nombre" name="nombre_mascota" required>

        <label for="raza">Raza:</label>
        <input type="text" id="raza" name="raza" required>

        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" required>

        <label for="ubicacion">Ubicación:</label>
        <input type="text" id="ubicacion" name="ubicacion" required>

        <label for="numero">Número del Dueño:</label>
        <input type="text" id="numero" name="numero_dueno" required>

        <label for="detalles">Detalles:</label>
        <textarea id="detalles" name="detalles" required></textarea>

        <label for="estado">Estado:</label>
        <select id="estado" name="estado" required>
            <option value="Desaparecido">Desaparecido</option>
            <option value="Encontrado">Encontrado</option>
        </select>

        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" name="imagen" accept="image/*" required>

        <!-- Campo oculto para el ID del usuario -->
        <input type="hidden" name="id_usuario" value="<?= $_SESSION['id_usuario'] ?? '' ?>">

        <button type="submit">Agregar</button>
        <button type="button" onclick="window.location.href='?page=reportes'">Volver Atrás</button>
    </form>
</div>

<script src="public/js/reportes_script.js"></script>
