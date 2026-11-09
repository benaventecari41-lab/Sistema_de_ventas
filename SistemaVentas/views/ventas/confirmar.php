<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Compra - Módulo 7</title>
    <link rel="stylesheet" href="public/css/estilos.css">
</head>
<body>
    <header class="navbar">
        <div class="nav-content">
            <h1>Tienda Virtual</h1>
            <nav>
                <a href="index.php?ruta=catalogo">Catálogo</a> |
                <a href="index.php?ruta=carrito">🛒 Mi Carrito</a>
            </nav>
        </div>
    </header>

    <main class="main-container">
        <h2>Confirmación de Compra</h2>

        <?php if (!empty($error)): ?>
            <div class="alerta error">
                <p><strong>Error al procesar la venta:</strong> <?= htmlspecialchars($error) ?></p>
                <a href="index.php?ruta=carrito">Volver al carrito</a>
            </div>
        <?php else: ?>
            <div class="resumen-confirmacion">
                <p>Por favor revise el detalle de su pedido antes de procesar la venta definitiva:</p>

                <table class="tabla-custom">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['carrito'] as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['nombre']) ?></td>
                                <td>S/ <?= number_format($item['precio'], 2) ?></td>
                                <td><?= $item['cantidad'] ?></td>
                                <td>S/ <?= number_format($item['precio'] * $item['cantidad'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="total-box">
                    <h3>Total Total: S/ <?= number_format($total, 2) ?></h3>
                </div>

                <form method="POST" action="index.php?ruta=procesar_compra">
                    <button type="submit" class="btn-exito-lg">✔ Confirmar y Generar Venta</button>
                    <a href="index.php?ruta=carrito" class="btn-secundario">Cancelar</a>
                </form>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
