<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: Login.php');
    exit();
}
$connection = mysqli_connect("localhost", "root", "", "persediaan_barang");
if (!$connection) {
    die("Koneksi database gagal: " . mysqli_connect_error());
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
    <title>Daftar Hadir II - INFOMEDIA</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f7f7f7; }
        .main-container { display: flex; min-height: 100vh; }
        .sidebar { background: #ff7f2a; color: #fff; width: 220px; padding: 0; display: flex; flex-direction: column; align-items: stretch; }
        .sidebar-header { background: #ff5555; padding: 30px 10px 20px 10px; text-align: center; font-size: 1.4em; font-weight: bold; letter-spacing: 2px; line-height: 1.2; }
        .sidebar-menu { flex: 1; padding: 0; margin: 0; list-style: none; }
        .sidebar-menu li { padding: 18px 25px; border-bottom: 1px solid #fff3; cursor: pointer; font-size: 1.1em; font-weight: bold; transition: background 0.2s; }
        .sidebar-menu li:hover, .sidebar-menu .active { background: #ff9f5a; }
        .sidebar-menu a { color: inherit; text-decoration: none; display: block; width: 100%; height: 100%; }
        .content { flex: 1; background: #fff; padding: 40px 30px; }
        .laporan-title { font-size: 1.3em; font-weight: bold; margin-bottom: 18px; }
        .daftar-table { width: 100%; border-collapse: collapse; background: #fff; }
        .daftar-table th, .daftar-table td { border: 1px solid #bbb; padding: 8px 10px; text-align: center; font-size: 1em; }
        .daftar-table th { background: #ffe0e0; }
        .daftar-table tr:nth-child(even) { background: #f9f9f9; }
        .daftar-table td.nama, .daftar-table th.nama { text-align: left; }
        .daftar-table td.jabatan, .daftar-table th.jabatan { text-align: left; }
        @media (max-width: 900px) { .main-container { flex-direction: column; } .sidebar { width: 100%; flex-direction: row; } .content { padding: 15px; } }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="sidebar">
            <div class="sidebar-header">
                ABSENSI KARYAWAN PT. INFOMEDIA
                <div style="font-size:0.7em;font-weight:normal;margin-top:4px;">Jl. Terusan Buahbatu No. 33</div>
            </div>
            <ul class="sidebar-menu">
                <li><a href="Entry_Karyawan(Adm).php">Entry Karyawan</a></li>
                <li><a href="daftar_hadir.php">Daftar Hadir</a></li>
                <li class="active"><a href="daftar_hadir2.php">Daftar Hadir II</a></li>
                <li><a href="laporan.php">Laporan</a></li>
                <li><a href="Logout.php">Logout</a></li>
            </ul>
        </div>
        <div class="content">
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
                    echo '</tr>';
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html> 