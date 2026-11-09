<?php
require_once __DIR__ . '/../config/database.php';

class Usuario {
    private $db;

    public function __construct() {
        $conexion = new Database();
        $this->db = $conexion->conectar();
    }

    public function registrar($nombre, $correo, $password) {
        $sql = "INSERT INTO usuarios (nombre, correo, password) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $nombre,
            $correo,
            password_hash($password, PASSWORD_DEFAULT)
        ]);
    }

    public function buscarCorreo($correo) {
        $sql = "SELECT * FROM usuarios WHERE correo = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$correo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
