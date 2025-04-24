<link rel="stylesheet" href="public/css/perfil_styles.css?v=<?= time() ?>">
<script src="public/js/perfil_script.js?v=<?= time() ?>" defer></script>

<div class="perfil-container">
    <div class="profile-container">
        <!-- Espacio para la foto de perfil -->
        <div class="foto-perfil-container">
            <div id="foto-perfil-placeholder" class="foto-placeholder">
                Agregar imagen
            </div>
            <img id="foto-perfil" class="foto-perfil" style="display: none;" alt="">
        </div>

        <!-- Campo para subir una nueva imagen -->
        <div class="form-group">
            <label for="foto">Subir nueva foto de perfil:</label>
            <input type="file" id="foto" name="foto" accept="image/*">
        </div>

        <h1 class="perfilT">Perfil de Usuario</h1>

        <form id="perfil-form">
            <div class="form-group">
                <label for="nombre">Nombre de Usuario:</label>
                <input type="text" id="nombre" name="nombre" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" placeholder="" readonly>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="contrasena-actual">Contraseña Actual:</label>
                <input type="password" id="contrasena-actual" name="contrasena-actual" placeholder="********" readonly>
            </div>
            <div class="form-group">
                <label for="contrasena">Nueva Contraseña (opcional):</label>
                <input type="password" id="contrasena" name="contrasena" placeholder="">
            </div>
            <div class="form-group">
                <label for="confirmar-contrasena">Confirmar Nueva Contraseña:</label>
                <input type="password" id="confirmar-contrasena" name="confirmar-contrasena" placeholder="">
            </div>
            <div class="profile-options">
                <button type="submit" class="btn">Guardar Cambios</button>
                <button type="reset" class="btn">Cancelar</button>
            </div>
        </form>
    </div>
</div>