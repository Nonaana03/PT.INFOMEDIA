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

// Proses simpan data absensi
if (isset($_POST['simpan'])) {
    $id_karyawan = mysqli_real_escape_string($connection, $_POST['id_karyawan']);
    $tanggal = mysqli_real_escape_string($connection, $_POST['tanggal']);
    $status = mysqli_real_escape_string($connection, $_POST['status']);
    $insert = mysqli_query($connection, "INSERT INTO absensi (id_karyawan, tanggal, status) VALUES ('$id_karyawan', '$tanggal', '$status')");
    if (!$insert) {
        echo '<div style="color:red;">Gagal menyimpan data: '.mysqli_error($connection).'</div>';
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
    <title>Daftar Hadir - INFOMEDIA</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f7f7f7; }
        .header { background: #f55; color: #fff; padding: 30px 0 20px 0; text-align: center; font-size: 2em; font-weight: bold; letter-spacing: 2px; }
        .container { display: flex; margin: 0 auto; max-width: 1100px; min-height: 80vh; }
        .sidebar { background: #ff7f2a; color: #fff; width: 250px; padding: 20px 0; }
        .sidebar h3 { text-align: center; margin-bottom: 30px; font-size: 1.2em; letter-spacing: 1px; }
        .menu { list-style: none; padding: 0; }
        .menu li { padding: 15px 30px; border-bottom: 1px solid #fff3; cursor: pointer; display: flex; align-items: center; }
        .menu li:hover { background: #ff9f5a; }
        .menu li:last-child { color: #ffb3b3; }
        .content { flex: 1; background: #fff; padding: 30px; }
        .form-entry { margin-bottom: 30px; border: 1px solid #ccc; padding: 20px; border-radius: 8px; background: #fafafa; max-width: 400px; }
        .form-entry h4 { margin-top: 0; }
        .form-entry label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-entry input[type="text"], .form-entry input[type="date"], .form-entry select { width: 95%; padding: 8px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; }
        .form-entry input[type="submit"] { padding: 8px 20px; background: #f55; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        .form-entry input[type="submit"]:hover { background: #d44; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { border: 1px solid #bbb; padding: 8px 10px; text-align: left; }
        th { background: #ffe0e0; }
        tr:nth-child(even) { background: #f9f9f9; }
    </style>
</head>
<body>
    <div class="header">
        ABSENSI KARYAWAN PT.INFOMEDIA<br>
        <span style="font-size:0.6em;font-weight:normal;">Jl. Terusan Buahbatu No. 33</span>
    </div>
    <div class="container">
        <div class="sidebar">
            <h3>MENU PILIHAN</h3>
            <ul class="menu">
                <li onclick="window.location.href='Entry_Karyawan(Adm).php'">📋 Entry Karyawan</li>
                <li onclick="window.location.href='daftar_hadir.php'">📅 Daftar Hadir</li>
                <li onclick="window.location.href='#'">📊 Laporan</li>
                <li onclick="window.location.href='Logout.php'">⏻ Logout</li>
            </ul>
        </div>
        <div class="content">
            <div class="form-entry">
                <h4>Entry Daftar Hadir</h4>
                <form method="post" action="">
                    <label for="id_karyawan">ID Karyawan</label>
                    <select id="id_karyawan" name="id_karyawan" required>
                        <option value="">-- Pilih Karyawan --</option>
                        <?php while ($row = mysqli_fetch_assoc($karyawan)) {
                            echo '<option value="'.htmlspecialchars($row['id']).'">'.htmlspecialchars($row['id']).' - '.htmlspecialchars($row['nama']).'</option>';
                        } ?>
                    </select>
                    <label for="tanggal">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" required>
                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        <option value="Hadir">Hadir</option>
                        <option value="Izin">Izin</option>
                        <option value="Sakit">Sakit</option>
                        <option value="Alpha">Alpha</option>
                    </select>
                    <input type="submit" name="simpan" value="Simpan">
                </form>
            </div>
            <h4>Daftar Hadir Karyawan</h4>
            <table>
                <tr>
                    <th>No</th>
                    <th>ID Karyawan</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($absensi)) {
                    echo '<tr>';
                    echo '<td>' . $no++ . '</td>';
                    echo '<td>' . htmlspecialchars($row['id_karyawan']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['nama']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['tanggal']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['status']) . '</td>';
                    echo '</tr>';
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html> 