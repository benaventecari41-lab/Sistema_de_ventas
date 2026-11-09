<?php
require_once 'config/sesion.php';

// Limpiar arreglo de sesión
session_unset();

// Destruir sesión
session_destroy();

// Redireccionar al login
header("Location: index.php?ruta=login");
exit;
?>
