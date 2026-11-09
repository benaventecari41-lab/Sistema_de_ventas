<?php
require_once __DIR__ . '/../models/Producto.php';

class ProductoController {
    private $producto;

    public function __construct() {
        $this->producto = new Producto();
    }

    public function catalogo($busqueda = '') {
        return $this->producto->listar($busqueda);
    }
}
?>
