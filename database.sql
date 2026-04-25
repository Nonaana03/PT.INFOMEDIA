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

-- Tambahkan kolom status ke tabel absensi jika belum ada
ALTER TABLE absensi ADD COLUMN status VARCHAR(20) DEFAULT 'Hadir' AFTER jam;

-- Tambah kolom jabatan ke tabel karyawan jika belum ada
ALTER TABLE karyawan ADD COLUMN jabatan VARCHAR(50) DEFAULT '-';

-- Contoh update jabatan karyawan
UPDATE karyawan SET jabatan = 'Staff' WHERE id = '1001';
UPDATE karyawan SET jabatan = 'Manager' WHERE id = '1002';
-- Tambahkan update lain sesuai kebutuhan