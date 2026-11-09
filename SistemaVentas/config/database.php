<?php
class Database {
    private $host = "localhost";
    private $dbname = "bd_ventas";
    private $user = "root";
    private $pass = "";

    public function conectar() {
        try {
            $conexion = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                $this->user,
                $this->pass
            );
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexion;
        } catch(PDOException $e) {
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }
}
?>
