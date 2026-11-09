<?php
require_once __DIR__ . '/../config/sesion.php';
require_once __DIR__ . '/../models/Venta.php';

class VentaController {
    private $ventaModel;

    public function __construct() {
        $this->ventaModel = new Venta();
    }

    public function procesarCompra() {
        verificarSesion();
        if (empty($_SESSION['carrito'])) {
            return ['exito' => false, 'error' => 'El carrito está vacío.'];
        }

        $res = $this->ventaModel->registrarVenta($_SESSION['usuario_id'], $_SESSION['carrito']);
        if ($res['exito']) {
            $_SESSION['carrito'] = []; // Vaciar carrito tras venta exitosa
        }
        return $res;
    }

    public function listarHistorial() {
        verificarSesion();
        return $this->ventaModel->obtenerVentasPorUsuario($_SESSION['usuario_id']);
    }

    public function obtenerDetalles($venta_id) {
        verificarSesion();
        return $this->ventaModel->obtenerDetallesVenta($venta_id, $_SESSION['usuario_id']);
    }

    public function generarComprobante($venta_id) {
        verificarSesion();
        return $this->ventaModel->obtenerComprobanteVenta($venta_id, $_SESSION['usuario_id']);
    }
}
?>
