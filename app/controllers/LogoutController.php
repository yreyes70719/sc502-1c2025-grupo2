<?php
session_start();
session_destroy();
header("Location: http://localhost/ProyectoAW/?page=login");
exit;
?>