-- Membuat database
CREATE DATABASE IF NOT EXISTS persediaan_barang;
USE persediaan_barang;

-- Membuat tabel user
CREATE TABLE IF NOT EXISTS user (
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    posisi ENUM('admin','manager') NOT NULL
);

-- Data contoh user
INSERT INTO user (username, password, posisi) VALUES
('admin', 'admin123', 'admin'),
('manager', 'manager123', 'manager');