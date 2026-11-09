<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Sistema de Ventas</title>
    <link rel="stylesheet" href="public/css/estilos.css">
</head>
<body>
    <div class="container">
        <h2>Iniciar Sesión</h2>

        <?php if (!empty($mensaje)): ?>
            <div class="alerta error"><?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php?ruta=login">
            <label for="correo">Correo electrónico</label>
            <input type="email" id="correo" name="correo" required placeholder="correo@ejemplo.com">

            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required placeholder="••••••••">

            <button type="submit">Ingresar</button>
        </form>

        <p style="text-align: center; margin-top: 15px;">
            ¿No tienes cuenta? <a href="index.php?ruta=registro">Crear una cuenta</a>
        </p>
    </div>
</body>
</html>
