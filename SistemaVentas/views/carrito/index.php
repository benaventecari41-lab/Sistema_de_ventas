<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Carrito de Compras</title>
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
        <h2>Mi Carrito de Compras</h2>

        <?php if (!empty($mensaje)): ?>
            <div class="alerta info"><?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>

        <?php if (empty($_SESSION['carrito'])): ?>
            <div class="carrito-vacio">
                <p>Tu carrito está vacío.</p>
                <a href="index.php?ruta=catalogo" class="btn-link">Ir al catálogo de productos</a>
            </div>
        <?php else: ?>
            <table class="tabla-custom">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio Unit.</th>
                        <th>Cantidad (Módulo 6)</th>
                        <th>Subtotal</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['carrito'] as $id => $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nombre']) ?></td>
                            <td>S/ <?= number_format($item['precio'], 2) ?></td>
                            <td>
                                <!-- Módulo 6: Modificación de cantidades -->
                                <form method="POST" action="index.php?ruta=actualizar_cantidad" class="form-actualizar">
                                    <input type="hidden" name="id" value="<?= $id ?>">
                                    <input type="number" name="cantidad" value="<?= $item['cantidad'] ?>" min="1" required style="width: 70px; display: inline-block;">
                                    <button type="submit" class="btn-sm">Actualizar</button>
                                </form>
                            </td>
                            <td>S/ <?= number_format($item['precio'] * $item['cantidad'], 2) ?></td>
                            <td>
                                <a href="index.php?ruta=eliminar&id=<?= $id ?>" class="btn-danger-sm" onclick="return confirm('¿Eliminar producto?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="carrito-resumen">
                <h3>Total a pagar: S/ <?= number_format($total, 2) ?></h3>
                <div class="acciones-carrito">
                    <a href="index.php?ruta=vaciar" class="btn-warning" onclick="return confirm('¿Vaciar todo el carrito?');">Vaciar carrito</a>
                    <a href="index.php?ruta=confirmar" class="btn-exito">Confirmar y Comprar</a>
                </div>
            </div>
        <?php endif; ?>

        <br>
        <a href="index.php?ruta=catalogo">← Seguir comprando</a>
    </main>
</body>
</html>
