<?php
require_once __DIR__ . '/../config/sesion.php';
require_once __DIR__ . '/../models/Producto.php';

class CarritoController {
    private $producto;

    public function __construct() {
        $this->producto = new Producto();
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
    }

    public function agregar($id, $cantidad) {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $cantidad = filter_var($cantidad, FILTER_VALIDATE_INT);

        if (!$id || !$cantidad || $cantidad < 1) {
            return "Datos de producto o cantidad no válidos.";
        }

        $prod = $this->producto->buscarPorId($id);
        if (!$prod) {
            return "El producto solicitado no existe.";
        }

        $cantActual = $_SESSION['carrito'][$id]['cantidad'] ?? 0;
        $nuevaCantidad = $cantActual + $cantidad;

        if ($nuevaCantidad > $prod['stock']) {
            return "No se puede agregar: stock insuficiente. Disponible: {$prod['stock']}";
        }

        $_SESSION['carrito'][$id] = [
            'nombre' => $prod['nombre'],
            'precio' => $prod['precio'],
            'cantidad' => $nuevaCantidad
        ];

        return "Producto agregado correctamente al carrito.";
    }

    public function actualizarCantidad($id, $cantidad) {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $cantidad = filter_var($cantidad, FILTER_VALIDATE_INT);

        if (!$id || !isset($_SESSION['carrito'][$id])) {
            return "El producto no existe en el carrito.";
        }

        if ($cantidad < 1) {
            return "La cantidad debe ser de al menos 1 unidad.";
        }

        $prod = $this->producto->buscarPorId($id);
        if (!$prod) {
            return "El producto no existe en la base de datos.";
        }

        if ($cantidad > $prod['stock']) {
            return "No hay suficiente stock. Stock disponible: {$prod['stock']}";
        }

        $_SESSION['carrito'][$id]['cantidad'] = $cantidad;
        return "Cantidad actualizada exitosamente.";
    }

    public function eliminar($id) {
        unset($_SESSION['carrito'][$id]);
    }

    public function vaciar() {
        $_SESSION['carrito'] = [];
    }

    public function calcularTotal() {
        $total = 0;
        if (isset($_SESSION['carrito']) && is_array($_SESSION['carrito'])) {
            foreach ($_SESSION['carrito'] as $item) {
                $total += $item['precio'] * $item['cantidad'];
            }
        }
        return $total;
    }
}
?>
