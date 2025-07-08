<?php
date_default_timezone_set('Asia/Jakarta');
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
    $status = isset($_POST['status']) ? mysqli_real_escape_string($connection, $_POST['status']) : 'Hadir';

    // Cek apakah karyawan ada
    $cek = mysqli_query($connection, "SELECT * FROM karyawan WHERE id='$id_karyawan'");
    if ($row = mysqli_fetch_assoc($cek)) {
        $foto = $row['foto'];
        $nama = $row['nama'];
        // Simpan absen
        $insert = mysqli_query($connection, "INSERT INTO absensi (id_karyawan, tanggal, jam, status) VALUES ('$id_karyawan', '$tanggal', '$jam', '$status')");
        if ($insert) {
            $sukses = "Absen berhasil untuk $nama pada $tanggal $jam";
        } else {
            $error = "Gagal menyimpan absen!";
        }
    } else {
        $error = "ID Karyawan tidak ditemukan!";
    }
}

// Ambil data karyawan
$karyawan = mysqli_query($connection, "SELECT * FROM karyawan ORDER BY nama ASC");
// Ambil tanggal unik dari absensi (7 hari terakhir)
$tanggal_q = mysqli_query($connection, "SELECT DISTINCT tanggal FROM absensi ORDER BY tanggal DESC LIMIT 7");
$tanggal_list = [];
while ($row = mysqli_fetch_assoc($tanggal_q)) {
    $tanggal_list[] = $row['tanggal'];
}
$tanggal_list = array_reverse($tanggal_list); // urut dari paling lama ke paling baru
// Ambil data absensi per karyawan per tanggal
$absensi = [];
$absensi_q = mysqli_query($connection, "SELECT id_karyawan, tanggal, status FROM absensi");
while ($row = mysqli_fetch_assoc($absensi_q)) {
    $absensi[$row['id_karyawan']][$row['tanggal']] = $row['status'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Absen & Rekap Kehadiran - INFOMEDIA</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f7f7f7; }
        .main-container { display: flex; min-height: 100vh; }
        .sidebar { background: #ff7f2a; color: #fff; width: 220px; padding: 0; display: flex; flex-direction: column; align-items: stretch; }
        .sidebar-menu { flex: 1; padding: 0; margin: 0; list-style: none; }
        .sidebar-menu li { padding: 18px 25px; border-bottom: 1px solid #fff3; cursor: pointer; font-size: 1.1em; font-weight: bold; transition: background 0.2s; }
        .sidebar-menu li:hover, .sidebar-menu .active { background: #ff9f5a; }
        .sidebar-menu a { color: inherit; text-decoration: none; display: block; width: 100%; height: 100%; }
        .content { flex: 1; background: #fff; padding: 40px 30px; }
        .absen-box { background: #fff; padding: 40px 30px; border-radius: 8px; box-shadow: 0 4px 24px rgba(0,0,0,0.1); text-align: center; max-width: 400px; margin: 0 auto 30px auto; }
        .absen-box input[type="text"] { width: 200px; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px; }
        .absen-box input[type="submit"] { padding: 8px 20px; background: #f55; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        .absen-box input[type="submit"]:hover { background: #d44; }
        .foto-karyawan { margin: 20px auto; width: 180px; height: 220px; object-fit: cover; border-radius: 8px; border: 1px solid #ccc; background: #eee; }
        .notif { margin: 10px 0; padding: 10px; border-radius: 5px; }
        .notif.sukses { background: #d4edda; color: #155724; }
        .notif.error { background: #f8d7da; color: #721c24; }
        .laporan-title { font-size: 1.3em; font-weight: bold; margin-bottom: 18px; }
        .daftar-table { width: 100%; border-collapse: collapse; background: #fff; }
        .daftar-table th, .daftar-table td { border: 1px solid #bbb; padding: 8px 10px; text-align: center; font-size: 1em; }
        .daftar-table th { background: #ffe0e0; }
        .daftar-table tr:nth-child(even) { background: #f9f9f9; }
        .daftar-table td.nama, .daftar-table th.nama { text-align: left; }
        .daftar-table td.jabatan, .daftar-table th.jabatan { text-align: left; }
        @media (max-width: 900px) { .main-container { flex-direction: column; } .sidebar { width: 100%; flex-direction: row; } .content { padding: 15px; } }
        .header {
            background: #ff5555;
            color: #fff;
            padding: 30px 0 20px 0;
            text-align: center;
            font-size: 2em;
            font-weight: bold;
            letter-spacing: 2px;
        }
        @media (max-width: 900px) {
            .header { font-size: 1.2em; padding: 18px 0 12px 0; }
        }
    </style>
</head>
<body>
    <div class="header">
        ABSENSI KARYAWAN PT. INFOMEDIA<br>
        <span style="font-size:0.7em;font-weight:normal;">Jl. Terusan Buahbatu No. 33</span>
    </div>
    <div class="main-container">
        <div class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="Menu_Utama.php">Menu Utama</a></li>
                <li><a href="Entry_Karyawan(Adm).php">Entry Karyawan</a></li>
                <li class="active"><a href="daftar_hadir.php">Daftar Hadir</a></li>
                <li><a href="laporan.php">Laporan</a></li>
                <li><a href="Logout.php">Logout</a></li>
            </ul>
        </div>
        <div class="content">
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
            <div class="laporan-title">Daftar Hadir Karyawan</div>
            <table class="daftar-table">
                <tr>
                    <th>No</th>
                    <th>ID</th>
                    <th class="nama">Nama</th>
                    <th class="jabatan">Jabatan</th>
                    <?php foreach ($tanggal_list as $tgl): ?>
                        <th><?= htmlspecialchars($tgl) ?></th>
                    <?php endforeach; ?>
                    <th>Opsi</th>
                </tr>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($karyawan)) {
                    echo '<tr>';
                    echo '<td>' . $no++ . '</td>';
                    echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                    echo '<td class="nama">' . htmlspecialchars($row['nama']) . '</td>';
                    echo '<td class="jabatan">' . (isset($row['jabatan']) ? htmlspecialchars($row['jabatan']) : '-') . '</td>';
                    foreach ($tanggal_list as $tgl) {
                        $status = isset($absensi[$row['id']][$tgl]) ? $absensi[$row['id']][$tgl] : '-';
                        echo '<td>' . htmlspecialchars($status) . '</td>';
                    }
                    echo '<td><a href="daftar_hadir.php?detail=' . htmlspecialchars($row['id']) . '" class="btn-detail">Detail</a></td>';
                    echo '</tr>';
                }
                ?>
            </table>

            <?php
            if (isset($_GET['detail'])) {
                $id_detail = mysqli_real_escape_string($connection, $_GET['detail']);
                $q = mysqli_query($connection, "SELECT * FROM karyawan WHERE id='$id_detail'");
                $k = mysqli_fetch_assoc($q);

                // Ambil jam masuk terakhir
                $masuk = mysqli_query($connection, "SELECT * FROM absensi WHERE id_karyawan='$id_detail' AND status='Masuk' ORDER BY tanggal DESC, jam DESC LIMIT 1");
                $row_masuk = mysqli_fetch_assoc($masuk);

                // Ambil jam keluar terakhir
                $keluar = mysqli_query($connection, "SELECT * FROM absensi WHERE id_karyawan='$id_detail' AND status='Keluar' ORDER BY tanggal DESC, jam DESC LIMIT 1");
                $row_keluar = mysqli_fetch_assoc($keluar);

                echo '<div style="border:1px solid #888; margin-top:30px; padding:18px 30px; max-width:600px; font-size:1.1em;">';
                echo '<b>Detail Absensi ' . htmlspecialchars($k['nama']) . '</b><br><br>';
                echo '<table style="width:100%">';
                echo '<tr><td style="width:120px;">id</td><td>: ' . htmlspecialchars($k['id']) . '</td></tr>';
                echo '<tr><td>nama</td><td>: ' . htmlspecialchars($k['nama']) . '</td></tr>';
                echo '<tr><td>Jabatan</td><td>: ' . htmlspecialchars($k['jabatan']) . '</td></tr>';
                echo '<tr><td>Jam Masuk</td><td>: ' . ($row_masuk ? htmlspecialchars($row_masuk['jam']) : '-') . '</td></tr>';
                echo '<tr><td>Jam Keluar</td><td>: ' . ($row_keluar ? htmlspecialchars($row_keluar['jam']) : '-') . '</td></tr>';
                echo '</table>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</body>
</html> 