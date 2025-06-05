CREATE DATABASE IF NOT EXISTS clinica;
USE clinica;

-- Tabla de usuarios (actualizada con apellidos y telefono)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(150) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    edad INT,
    imagen VARCHAR(255) NOT NULL,
    descripcion TEXT,
    gmail VARCHAR(100) UNIQUE NOT NULL,
    permisos TINYINT(1) NOT NULL DEFAULT 0,
    contrasenya VARCHAR(255) NOT NULL
);

-- Tabla de mensajes (citas)
CREATE TABLE IF NOT EXISTS mensajes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL,
    nombre_cliente VARCHAR(100),
    titulo_cita VARCHAR(100),
    descripcion TEXT,
    zona_dolorida VARCHAR(100),
    fecha_cita DATE,
    id_fisio INT NOT NULL,
    estado ENUM('enviado', 'aceptado', 'rechazado') NOT NULL DEFAULT 'enviado',
    FOREIGN KEY (id_cliente) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (id_fisio) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Insertar usuarios (actualizado con apellidos y telefono)
INSERT INTO usuarios (nombre, apellidos, telefono, edad, imagen, descripcion, gmail, permisos, contrasenya) VALUES
('Jesus', 'Ramírez López', '600111222', 34, 'default.png', 'Especialista en lesiones deportivas', 'jesus@clinica.com', 1, '$2y$10$NCQL1vsTeZRJasOqZfFhJOGJCeP872.ifPicHCem/tX8/k0HAI4NG'),
('Luis', 'González Pérez', '600222333', 41, 'default.png', 'Dolores de espalda y cuello', 'luis@clinica.com', 1, '$2y$10$UycR3sySl4fZl9LKVNrlLu/gHSKTjXmWmg9.utQh43ArwvzMJ6/M6'),
('Ismael', 'Torres Núñez', '600333444', 38, 'default.png', 'Postoperatorios y adultos mayores', 'ismael@clinica.com', 1, '$2y$10$3VuQPKNklJ0141cTTgGZs.g2qcIKbyb9zLQU/Fts9kxWvDdLlcvfy'),
('admin', 'Admin', '600000000', 29, 'default.png', '', 'admin@gmail.com', 0, '$2y$10$dIBvy.QseqFNzP7GErgSF.P7coKdx/onIiO4QNiiLnbwYyPMxOUFm'),
('Alvaro', 'Méndez Soto', '600444555', 45, '6cukfi.jpg', '', 'alvaro@gmail.com', 0, '$2y$10$vQIVG0TXOTD88Jmkhx9I0e2PCPNaDyUJsfaiEo9AyS4zcb/kcGZHy'),
('Ana', 'López García', '600555666', 36, 'default.png', '', 'ana@gmail.com', 0, '$2y$10$2ChEUT3mIJBMYbJG7h75HOiX.l5XbvLX7Ns8WmfZjpYPzCTpi7Ph.');

-- Insertar mensajes
INSERT INTO mensajes (id_cliente, nombre_cliente, titulo_cita, descripcion, zona_dolorida, fecha_cita, id_fisio) VALUES
(5, 'Alvaro', 'Dolor lumbar', 'Dolor persistente en la zona baja de la espalda', 'Espalda baja', '2025-06-02', 1),
(6, 'Ana', 'Revisión de hombro', 'Dolor tras jugar tenis', 'Hombro derecho', '2025-06-05', 2),
(6, 'Ana', 'Lesión de rodilla', 'Me caí corriendo, y me duele al doblarla', 'Rodilla izquierda', '2025-06-10', 3);