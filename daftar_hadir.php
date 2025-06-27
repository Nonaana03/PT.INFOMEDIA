<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: Login.php');
    exit();
}

// Koneksi ke database
$connection = mysqli_connect("localhost", "root", "", "persediaan_barang");
if (!$connection) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Cek jika tabel absensi belum ada
$table_check = mysqli_query($connection, "SHOW TABLES LIKE 'absensi'");
if (mysqli_num_rows($table_check) == 0) {
    echo '<div style="color:red;padding:20px;">Tabel <b>absensi</b> belum ada di database. Silakan buat tabel absensi terlebih dahulu.</div>';
    exit();
}

$foto = '';
$nama = '';
$sukses = '';
$error = '';

if (isset($_POST['absen'])) {
    $id_karyawan = mysqli_real_escape_string($connection, $_POST['id_karyawan']);
    $tanggal = date('Y-m-d');
    $jam = date('H:i:s');

    // Cek apakah karyawan ada
    $cek = mysqli_query($connection, "SELECT * FROM karyawan WHERE id='$id_karyawan'");
    if ($row = mysqli_fetch_assoc($cek)) {
        $foto = $row['foto'];
        $nama = $row['nama'];
        // Simpan absen
        $insert = mysqli_query($connection, "INSERT INTO absensi (id_karyawan, tanggal, jam) VALUES ('$id_karyawan', '$tanggal', '$jam')");
        if ($insert) {
            $sukses = "Absen berhasil untuk $nama pada $tanggal $jam";
        } else {
            $error = "Gagal menyimpan absen!";
        }
    } else {
        $error = "ID Karyawan tidak ditemukan!";
    }
}

// Ambil data absensi
$absensi = mysqli_query($connection, "SELECT a.*, k.nama FROM absensi a LEFT JOIN karyawan k ON a.id_karyawan = k.id ORDER BY a.tanggal DESC, a.id_karyawan ASC");
// Ambil data karyawan untuk dropdown
$karyawan = mysqli_query($connection, "SELECT * FROM karyawan ORDER BY nama ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Absen Karyawan - INFOMEDIA</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f7f7f7; }
        .header { background: #f55; color: #fff; padding: 30px 0 20px 0; text-align: center; font-size: 2em; font-weight: bold; letter-spacing: 2px; }
        .container { display: flex; justify-content: center; align-items: center; min-height: 80vh; }
        .absen-box { background: #fff; padding: 40px 30px; border-radius: 8px; box-shadow: 0 4px 24px rgba(0,0,0,0.1); text-align: center; }
        .absen-box input[type="text"] { width: 200px; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px; }
        .absen-box input[type="submit"] { padding: 8px 20px; background: #f55; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        .absen-box input[type="submit"]:hover { background: #d44; }
        .foto-karyawan { margin: 20px auto; width: 180px; height: 220px; object-fit: cover; border-radius: 8px; border: 1px solid #ccc; background: #eee; }
        .notif { margin: 10px 0; padding: 10px; border-radius: 5px; }
        .notif.sukses { background: #d4edda; color: #155724; }
        .notif.error { background: #f8d7da; color: #721c24; }
        .sidebar-menu a {
            color: inherit;
            text-decoration: none;
            display: block;
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
    <div class="header">
        ABSENSI KARYAWAN PT.INFOMEDIA<br>
        <span style="font-size:0.6em;font-weight:normal;">Jl. Terusan Buahbatu No. 33</span>
    </div>
    <div class="container">
        <div class="absen-box">
            <form method="post" action="">
                <label for="id_karyawan">ID Karyawan</label><br>
                <input type="text" id="id_karyawan" name="id_karyawan" required autofocus>
                <input type="submit" name="absen" value="Absen">
            </form>
            <?php if ($sukses): ?>
                <div class="notif sukses"><?= htmlspecialchars($sukses) ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="notif error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if ($foto): ?>
                <img src="foto/<?= htmlspecialchars($foto) ?>" alt="Foto Karyawan" class="foto-karyawan"><br>
                <b><?= htmlspecialchars($nama) ?></b>
            <?php endif; ?>
        </div>
    </div>
</body>
</html> 