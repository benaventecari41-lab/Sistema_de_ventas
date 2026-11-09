<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <link rel="stylesheet" href="public/css/estilos.css">
</head>
<body>
    <header class="navbar">
        <div class="nav-content">
            <h1>Tienda Virtual</h1>
            <nav>
                <span>Bienvenido, <strong><?= htmlspecialchars($_SESSION['nombre']) ?></strong></span> |
                <a href="index.php?ruta=catalogo">Catálogo</a> |
                <a href="index.php?ruta=carrito">
                    🛒 Mi Carrito (<?= isset($_SESSION['carrito']) ? array_sum(array_column($_SESSION['carrito'], 'cantidad')) : 0 ?>)
                </a> |
                <a href="index.php?ruta=historial">📜 Mis Compras</a> |
                <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
            </nav>
        </div>
    </header>

    <main class="main-container">
        <h2>Catálogo de Productos</h2>

        <?php if (!empty($mensaje)): ?>
            <div class="alerta exito"><?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>

        <!-- Reto Final #1: Buscador de productos -->
        <form method="GET" action="index.php" class="buscador-form">
            <input type="hidden" name="ruta" value="catalogo">
            <input type="text" name="b" value="<?= htmlspecialchars($busqueda ?? '') ?>" placeholder="Buscar por nombre o descripción...">
            <button type="submit">Buscar</button>
            <?php if (!empty($busqueda)): ?>
                <a href="index.php?ruta=catalogo" class="btn-secundario">Limpiar</a>
            <?php endif; ?>
        </form>

        <div class="productos">
            <?php if (empty($productos)): ?>
                <p>No se encontraron productos disponibles.</p>
            <?php else: ?>
                <?php foreach ($productos as $p): ?>
                    <div class="producto">
                        <h3><?= htmlspecialchars($p['nombre']) ?></h3>
                        <p class="desc"><?= htmlspecialchars($p['descripcion']) ?></p>
                        <p class="precio">S/ <?= number_format($p['precio'], 2) ?></p>
                        <p class="stock">Stock: <?= $p['stock'] ?></p>

                        <?php if ($p['stock'] > 0): ?>
                            <form method="POST" action="index.php?ruta=agregar">
                                <input type="hidden" name="producto_id" value="<?= $p['id'] ?>">
                                <div class="form-group-inline">
                                    <label>Cant:</label>
                                    <input type="number" name="cantidad" value="1" min="1" max="<?= $p['stock'] ?>" required>
                                </div>
                                <button type="submit">Agregar al carrito</button>
                            </form>
                        <?php else: ?>
                            <p class="agotado">Agotado</p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
