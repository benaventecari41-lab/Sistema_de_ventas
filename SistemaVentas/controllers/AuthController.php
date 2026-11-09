<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../config/sesion.php';

class AuthController {
    private $usuario;

    public function __construct() {
        $this->usuario = new Usuario();
    }

    public function login($correo, $password) {
        $user = $this->usuario->buscarCorreo($correo);
        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['correo'] = $user['correo'];
            header("Location: index.php?ruta=catalogo");
            exit;
        }
        return "Correo electrónico o contraseña incorrectos.";
    }

    public function registro($nombre, $correo, $password) {
        if (empty($nombre) || empty($correo) || empty($password)) {
            return "Todos los campos son obligatorios.";
        }
        if (strlen($password) < 8) {
            return "La contraseña debe tener al menos 8 caracteres.";
        }
        if ($this->usuario->buscarCorreo($correo)) {
            return "El correo ya se encuentra registrado.";
        }
        if ($this->usuario->registrar($nombre, $correo, $password)) {
            return "Usuario registrado correctamente. ¡Ya puedes iniciar sesión!";
        }
        return "Error al registrar el usuario.";
    }
}
?>
