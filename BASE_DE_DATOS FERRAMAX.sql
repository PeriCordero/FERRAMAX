CREATE DATABASE IF NOT EXISTS ferramax;
USE ferramax;
ALTER TABLE PRODUCTOS ADD CATEGORIA VARCHAR(50);
ALTER TABLE PRODUCTOS
ADD MARCA VARCHAR(9),
ADD FECHA_REGISTRO DATETIME NOT NULL;
ALTER TABLE PRODUCTOS MODIFY MARCA VARCHAR(50) NOT NULL;

CREATE TABLE PRODUCTOS (

ID INT AUTO_INCREMENT PRIMARY KEY,
MARCA VARCHAR(9) NOT NULL,
NOMBRE_PRODUCTO VARCHAR(100) NOT NULL,
PRICE DECIMAL(10,2) NOT NULL,
FECHA_REGISTRO DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE USUARIOS(
ID INT AUTO_INCREMENT PRIMARY KEY,
NOMBRE_USUARIO VARCHAR(100) NOT NULL,
EMAIL VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE TIPO_PRODUCTO (
ID INT AUTO_INCREMENT PRIMARY KEY,
TIPO_HERRAMIENTA VARCHAR(70) NOT NULL
);
CREATE TABLE INICIO_SESION_USER (
  ID INT AUTO_INCREMENT PRIMARY KEY,
  NOMBRE_USUARIO VARCHAR(50) NOT NULL UNIQUE,
  CLAVE_HASH VARCHAR(255) NOT NULL
);
CREATE TABLE SUSCRIPCIONES (
  ID INT AUTO_INCREMENT PRIMARY KEY,
  EMAIL VARCHAR(100) NOT NULL UNIQUE,
  FECHA_SUSCRIPCION DATETIME DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO PRODUCTOS (MARCA, NOMBRE_PRODUCTO, PRICE) VALUES
('Bosch', 'Taladro Percutor Bosch 500W', 89990),
('Stanley', 'Martillo Stanley Mango de Fibra', 14990),
('Makita', 'Lijadora Orbital Makita 180W', 65990),
('3M', 'Lentes de Seguridad 3M Antiempañante', 8990),
('Sipa', 'Pintura Látex Interior Blanco 4L', 23990),
('Weber', 'Cemento Cola Cerámico 25kg', 10990),
('DeWalt', 'Atornillador Eléctrico DeWalt 18V', 115000);

-- Insertar productos clasificados
INSERT INTO PRODUCTOS (MARCA, NOMBRE_PRODUCTO, PRICE, CATEGORIA) VALUES
-- Herramientas manuales
('Stanley', 'Martillo de carpintero Stanley', 15990, 'Herramientas manuales'),
('Bosch', 'Taladro percutor Bosch 500W', 89990, 'Herramientas manuales'),
('Makita', 'Lijadora orbital Makita 180W', 69990, 'Herramientas manuales'),
('DeWalt', 'Atornillador eléctrico DeWalt 18V', 115000, 'Herramientas manuales'),
('Tramontina', 'Destornillador plano Tramontina', 4990, 'Herramientas manuales'),

-- Materiales básicos
('Weber', 'Cemento cola cerámico 25kg', 10990, 'Materiales básicos'),
('Sipa', 'Pintura látex blanco interior 4L', 23990, 'Materiales básicos'),
('Bauker', 'Ladrillos huecos de arcilla (unidad)', 450, 'Materiales básicos'),
('Tricolor', 'Barniz protector madera 1L', 8990, 'Materiales básicos'),

-- Equipos de seguridad
('3M', 'Lentes de seguridad 3M antiempañante', 8990, 'Equipos de seguridad'),
('SteelPro', 'Casco de seguridad industrial SteelPro', 7990, 'Equipos de seguridad'),
('3M', 'Guantes de nitrilo 3M resistentes químicos', 5990, 'Equipos de seguridad'),

-- Tornillos y fijaciones
('Sika', 'Adhesivo de montaje SikaBond 300ml', 3990, 'Tornillos y fijaciones'),
('Fischer', 'Tornillo cabeza hexagonal Fischer x10', 2490, 'Tornillos y fijaciones'),
('Bauker', 'Anclaje metálico para concreto M10', 1590, 'Tornillos y fijaciones'),

-- Equipos de medición
('Stanley', 'Cinta métrica Stanley 5m', 4990, 'Equipos de medición'),
('Bosch', 'Medidor láser Bosch GLM 40', 89990, 'Equipos de medición'),
('Truper', 'Nivel burbuja Truper 60cm', 7990, 'Equipos de medición');
