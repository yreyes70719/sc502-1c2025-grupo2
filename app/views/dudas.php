<?php
require_once __DIR__ . '/../models/Duda.php';
$dudas = Duda::getAll();
?>

<link rel="stylesheet" href="public/css/dudas_styles.css?v=<?= time() ?>">

<div class="dudas-container mt-4">
    <header class="mb-4">
        <h1 class="text-center dudasT">Dudas Registradas</h1>
        <p class="text-center parrafoT">Todas las dudas almacenadas en el sistema y sus detalles.</p>
    </header>

    <hr>

    <main>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Mensaje</th>
                    <th>Fecha de Envío</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($dudas) && !isset($dudas['error'])): ?>
                    <?php foreach ($dudas as $duda): ?>
                        <tr>
                            <td><?= $duda['id_duda'] ?></td>
                            <td><?= $duda['nombre'] ?></td>
                            <td><?= $duda['correo'] ?></td>
                            <td><?= $duda['mensaje'] ?></td>
                            <td><?= $duda['fecha_envio'] ?></td>
                            <td>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $duda['id_duda'] ?>">Borrar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No hay dudas registradas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
    <script src="public/js/dudas_script.js?v=<?= time() ?>"></script>
</div>
