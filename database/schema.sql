-- Base de datos del módulo de Gestión de Incidencias
CREATE DATABASE IF NOT EXISTS erp_incidencias
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE erp_incidencias;

-- Incidencia registrada para un empleado
CREATE TABLE IF NOT EXISTS incidencias (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    empleado_id   INT UNSIGNED NOT NULL,
    tipo          ENUM('falta', 'retardo', 'permiso', 'incapacidad', 'vacaciones') NOT NULL,
    fecha_inicio  DATE NOT NULL,
    fecha_fin     DATE NOT NULL,
    motivo        VARCHAR(255) NOT NULL,
    estado        ENUM('pendiente', 'aprobada', 'rechazada', 'justificada') NOT NULL DEFAULT 'pendiente',
    creado_en     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_empleado (empleado_id),
    INDEX idx_estado_fecha (estado, fecha_inicio)
) ENGINE = InnoDB;

-- Historial de cambios de estado de cada incidencia
CREATE TABLE IF NOT EXISTS incidencias_historial (
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    incidencia_id  INT UNSIGNED NOT NULL,
    estado         ENUM('pendiente', 'aprobada', 'rechazada', 'justificada') NOT NULL,
    cambiado_en    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (incidencia_id) REFERENCES incidencias (id)
) ENGINE = InnoDB;
