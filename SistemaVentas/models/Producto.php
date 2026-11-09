<?php
require_once __DIR__ . '/../config/database.php';

class Producto {
    private $db;

    public function __construct() {
        $conexion = new Database();
        $this->db = $conexion->conectar();
    }

    public function listar($busqueda = '') {
        if (!empty($busqueda)) {
            $sql = "SELECT * FROM productos WHERE nombre LIKE ? OR descripcion LIKE ? ORDER BY nombre";
            $stmt = $this->db->prepare($sql);
            $term = "%{$busqueda}%";
            $stmt->execute([$term, $term]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        $sql = "SELECT * FROM productos ORDER BY nombre";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id) {
        $sql = "SELECT * FROM productos WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
