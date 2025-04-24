<link rel="stylesheet" href="public/css/perfil_styles.css">

<div class="perfil-container">
    <div class="profile-container">
        <h1 class="perfilT">Perfil de Usuario</h1>
        <div class="profile-picture">
            <img src="public/images/perfil.jpg" alt="Foto de Perfil" class="profile-img">
        </div>
        <form>
            <div class="form-group">
                <label for="nombre">Nombre de Usuario:</label>
                <input type="text" id="nombre" name="nombre" placeholder="Juan Pérez" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" placeholder="juan.perez@example.com" required>
            </div>
            <div class="form-group">
                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" placeholder="********" required>
            </div>
            <div class="form-group">
                <label for="confirmar-contrasena">Confirmar Contraseña:</label>
                <input type="password" id="confirmar-contrasena" name="confirmar-contrasena" placeholder="********" required>
            </div>
            <div class="profile-options">
                <button type="submit" class="btn">Guardar Cambios</button>
                <button type="reset" class="btn">Cancelar</button>
            </div>
        </form>
    </div>
</div>