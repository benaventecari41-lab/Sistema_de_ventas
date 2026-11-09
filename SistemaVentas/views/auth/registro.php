<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta - Sistema de Ventas</title>
    <link rel="stylesheet" href="public/css/estilos.css">
</head>
<body>
    <div class="container">
        <h2>Crear Cuenta</h2>

        <?php if (!empty($mensaje)): ?>
            <div class="alerta <?= strpos($mensaje, 'correctamente') !== false ? 'exito' : 'error' ?>">
                <?= htmlspecialchars($mensaje) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php?ruta=registro">
            <label for="nombre">Nombre completo</label>
            <input type="text" id="nombre" name="nombre" required placeholder="Ej. Juan Pérez">

            <label for="correo">Correo electrónico</label>
            <input type="email" id="correo" name="correo" required placeholder="correo@ejemplo.com">

            <label for="password">Contraseña (Mínimo 8 caracteres)</label>
            <input type="password" id="password" name="password" minlength="8" required placeholder="••••••••">

            <button type="submit">Registrarme</button>
        </form>

        <p style="text-align: center; margin-top: 15px;">
            ¿Ya tienes cuenta? <a href="index.php?ruta=login">Iniciar sesión</a>
        </p>
    </div>
</body>
</html>
