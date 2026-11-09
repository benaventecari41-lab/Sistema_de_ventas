-- Creación de la base de datos bd_ventas
CREATE DATABASE IF NOT EXISTS bd_ventas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE bd_ventas;

-- Tabla de usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de productos
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    imagen VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de ventas
CREATE TABLE IF NOT EXISTS ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de detalle de venta
CREATE TABLE IF NOT EXISTS detalle_venta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venta_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (venta_id) REFERENCES ventas(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar productos iniciales de prueba
INSERT INTO productos (nombre, descripcion, precio, stock, imagen) VALUES
('Teclado mecánico', 'Teclado USB switches blue RGB', 120.00, 15, 'teclado.jpg'),
('Mouse inalámbrico', 'Mouse óptico recargable 2.4GHz', 45.00, 20, 'mouse.jpg'),
('Audífonos', 'Audífonos con micrófono surround 7.1', 80.00, 10, 'audifonos.jpg'),
('Monitor 24 pulgadas', 'Monitor LED IPS Full HD 75Hz', 550.00, 8, 'monitor.jpg'),
('Webcam HD', 'Cámara para videollamadas 1080p', 95.00, 12, 'webcam.jpg');
