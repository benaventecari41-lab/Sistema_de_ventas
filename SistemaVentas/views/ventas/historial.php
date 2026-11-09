<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Compras - Módulo 8</title>
    <link rel="stylesheet" href="public/css/estilos.css">
</head>
<body>
    <header class="navbar">
        <div class="nav-content">
            <h1>Tienda Virtual</h1>
            <nav>
                <span>Bienvenido, <strong><?= htmlspecialchars($_SESSION['nombre']) ?></strong></span> |
                <a href="index.php?ruta=catalogo">Catálogo</a> |
                <a href="index.php?ruta=carrito">🛒 Mi Carrito</a> |
                <a href="index.php?ruta=historial">📜 Mis Compras</a> |
                <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
            </nav>
        </div>
    </header>

    <main class="main-container">
        <h2>Historial de Compras Realizadas</h2>

        <?php if (empty($ventas)): ?>
            <p>Aún no has registrado ninguna compra.</p>
        <?php else: ?>
            <table class="tabla-custom">
                <thead>
                    <tr>
                        <th>N° Venta</th>
                        <th>Fecha y Hora</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ventas as $v): ?>
                        <tr>
                            <td>#<?= str_pad($v['id'], 5, '0', STR_PAD_LEFT) ?></td>
                            <td><?= date('d/m/Y H:i:s', strtotime($v['fecha'])) ?></td>
                            <td>S/ <?= number_format($v['total'], 2) ?></td>
                            <td>
                                <a href="index.php?ruta=comprobante&id=<?= $v['id'] ?>" class="btn-sm" target="_blank">📄 Ver Comprobante</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        <br>
        <a href="index.php?ruta=catalogo">← Volver al catálogo</a>
    </main>
</body>
</html>
