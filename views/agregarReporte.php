<link rel="stylesheet" href="public/css/reportes_styles.css">

<div class="form-container">
    <h2 class="reportesT">Agrega un Nuevo Reporte</h2>
    <h3>¡Ayudemos a reunir familias!</h3>
    <p class="parrafoT">Si has perdido o encontrado una mascota, publica un reporte con los detalles para que la comunidad pueda ayudarte.</p>
    <form id="nuevo-reporte-form">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        
        <label for="raza">Raza:</label>
        <input type="text" id="raza" name="raza" required>
        
        <label for="edad">Edad:</label>
        <input type="text" id="edad" name="edad" required>
        
        <label for="ubicacion">Ubicación:</label>
        <input type="text" id="ubicacion" name="ubicacion" required>
        
        <label for="numero">Número del Dueño:</label>
        <input type="text" id="numero" name="numero" required>
        
        <label for="detalles">Detalles:</label>
        <textarea id="detalles" name="detalles" required></textarea>
        
        <label for="estado">Estado:</label>
        <select id="estado" name="estado" required>
            <option value="desaparecido">Desaparecido</option>
            <option value="encontrado">Encontrado</option>
        </select>
        
        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" name="imagen" accept="image/*" required>
        
        <button type="submit">Agregar</button>
        <button type="button" onclick="window.location.href='?page=reportes'">Volver Atrás</button>
    </form>
</div>
