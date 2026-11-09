<?php
require_once __DIR__ . '/../config/database.php';

class Venta {
    private $db;

    public function __construct() {
        $conexion = new Database();
        $this->db = $conexion->conectar();
    }

    public function registrarVenta($usuario_id, $carritoItems) {
        try {
            $this->db->beginTransaction();

            // 1. Verificar stock y precios actualizados en BD
            $totalCalculado = 0;
            $detallesProcesados = [];

            foreach ($carritoItems as $producto_id => $item) {
                $stmt = $this->db->prepare("SELECT precio, stock, nombre FROM productos WHERE id = ? FOR UPDATE");
                $stmt->execute([$producto_id]);
                $prodBD = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$prodBD) {
                    throw new Exception("El producto ID {$producto_id} ya no existe.");
                }

                if ($prodBD['stock'] < $item['cantidad']) {
                    throw new Exception("Stock insuficiente para: {$prodBD['nombre']}. Stock disponible: {$prodBD['stock']}");
                }

                $subtotal = $prodBD['precio'] * $item['cantidad'];
                $totalCalculado += $subtotal;

                $detallesProcesados[] = [
                    'producto_id' => $producto_id,
                    'cantidad' => $item['cantidad'],
                    'precio' => $prodBD['precio'],
                    'subtotal' => $subtotal
                ];
            }

            // 2. Insertar cabecera de la venta
            $sqlVenta = "INSERT INTO ventas (usuario_id, total) VALUES (?, ?)";
            $stmtVenta = $this->db->prepare($sqlVenta);
            $stmtVenta->execute([$usuario_id, $totalCalculado]);
            $venta_id = $this->db->lastInsertId();

            // 3. Insertar detalle y actualizar stock
            $sqlDetalle = "INSERT INTO detalle_venta (venta_id, producto_id, cantidad, precio, subtotal) VALUES (?, ?, ?, ?, ?)";
            $stmtDetalle = $this->db->prepare($sqlDetalle);

            $sqlStock = "UPDATE productos SET stock = stock - ? WHERE id = ?";
            $stmtStock = $this->db->prepare($sqlStock);

            foreach ($detallesProcesados as $det) {
                $stmtDetalle->execute([
                    $venta_id,
                    $det['producto_id'],
                    $det['cantidad'],
                    $det['precio'],
                    $det['subtotal']
                ]);

                $stmtStock->execute([
                    $det['cantidad'],
                    $det['producto_id']
                ]);
            }

            $this->db->commit();
            return ['exito' => true, 'venta_id' => $venta_id];
        } catch (Exception $e) {
            $this->db->rollBack();
            return ['exito' => false, 'error' => $e->getMessage()];
        }
    }

    public function obtenerVentasPorUsuario($usuario_id) {
        $sql = "SELECT * FROM ventas WHERE usuario_id = ? ORDER BY fecha DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDetallesVenta($venta_id, $usuario_id) {
        $sql = "SELECT v.id as venta_id, v.fecha, v.total, p.nombre, dv.cantidad, dv.precio, dv.subtotal 
                FROM ventas v 
                INNER JOIN detalle_venta dv ON v.id = dv.venta_id 
                INNER JOIN productos p ON dv.producto_id = p.id 
                WHERE v.id = ? AND v.usuario_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$venta_id, $usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerComprobanteVenta($venta_id, $usuario_id) {
        $sqlVenta = "SELECT v.id, v.fecha, v.total, u.nombre as cliente_nombre, u.correo 
                     FROM ventas v 
                     INNER JOIN usuarios u ON v.usuario_id = u.id 
                     WHERE v.id = ? AND v.usuario_id = ?";
        $stmtVenta = $this->db->prepare($sqlVenta);
        $stmtVenta->execute([$venta_id, $usuario_id]);
        $cabecera = $stmtVenta->fetch(PDO::FETCH_ASSOC);

        if (!$cabecera) return null;

        $sqlItems = "SELECT p.nombre, dv.cantidad, dv.precio, dv.subtotal 
                     FROM detalle_venta dv 
                     INNER JOIN productos p ON dv.producto_id = p.id 
                     WHERE dv.venta_id = ?";
        $stmtItems = $this->db->prepare($sqlItems);
        $stmtItems->execute([$venta_id]);
        $items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

        return [
            'cabecera' => $cabecera,
            'items' => $items
        ];
    }
}
?>
