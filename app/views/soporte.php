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
                <tr>
                    <td><strong>¿Cómo recupero mi contraseña?</strong></td>
                    <td>Ve a la pantalla de inicio de sesión y haz clic en "Olvidé mi contraseña". Luego ingresa tu correo y sigue las instrucciones enviadas.</td>
                </tr>
                <tr>
                    <td><strong>¿Cómo puedo adoptar una mascota?</strong></td>
                    <td>Ve a la sección Adopción y busca una mascota. Luego contacta al dueño o rescatista mediante el botón de "Solicitar Adopción".</td>
                </tr>
                <tr>
                    <td><strong>¿Cómo reporto una mascota perdida?</strong></td>
                    <td>Accede a la sección de reportes y completa el formulario con los detalles de la mascota. Por último, haz clic en "Enviar" para que se publique el reporte.</td>
                </tr>
                <tr>
                    <td><strong>¿Cómo cambio mi información personal?</strong></td>
                    <td>Desde tu Perfil, accede a la opción de "Editar información" y actualiza los datos que necesites.</td>
                </tr>
            </tbody>
        </table>
    </section>

    <hr class="divisor">

    <section class="contact-form">
        <h3 class="titulo-destacados">Formulario de Reporte (Problemas/Dudas)</h3>
        <form action="submit_form.php" method="post">
            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="message">Reporte:</label>
                <textarea id="message" name="message" required></textarea>
            </div>

            <button type="submit">Enviar</button>
        </form>
    </section>

    <hr class="divisor">

    <section class="soporteEmail">
        <h3 class="titulo-destacados">Correo de Soporte</h3>
        <p class="parrafoT">Para asistencia inmediata envíanos un correo a <a href="mailto:soporte@pawfinder.com">soporte@pawfinder.com</a>.</p>
        <p class="diagonal">Incluye tu nombre y una descripción clara del problema para una mejor asistencia.</p>
    </section>
</div>