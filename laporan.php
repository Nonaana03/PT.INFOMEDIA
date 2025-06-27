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
// Ambil data absensi gabung dengan nama karyawan
$query = mysqli_query($connection, "SELECT k.nama, a.tanggal, MIN(a.jam) as jam_masuk, MAX(a.jam) as jam_keluar, '' as keterangan FROM absensi a LEFT JOIN karyawan k ON a.id_karyawan = k.id GROUP BY a.tanggal, a.id_karyawan ORDER BY a.tanggal DESC, k.nama ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Absensi - INFOMEDIA</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f7f7f7;
        }
        .main-container {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            background: #ff7f2a;
            color: #fff;
            width: 220px;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: stretch;
        }
        .sidebar-header {
            background: #ff5555;
            padding: 30px 10px 20px 10px;
            text-align: center;
            font-size: 1.4em;
            font-weight: bold;
            letter-spacing: 2px;
            line-height: 1.2;
        }
        .sidebar-menu {
            flex: 1;
            padding: 0;
            margin: 0;
            list-style: none;
        }
        .sidebar-menu li {
            padding: 18px 25px;
            border-bottom: 1px solid #fff3;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: bold;
            transition: background 0.2s;
        }
        .sidebar-menu li:hover, .sidebar-menu .active {
            background: #ff9f5a;
        }
        .content {
            flex: 1;
            background: #fff;
            padding: 40px 30px;
        }
        .laporan-title {
            font-size: 1.3em;
            font-weight: bold;
            margin-bottom: 18px;
        }
        .laporan-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }
        .laporan-table th, .laporan-table td {
            border: 1px solid #bbb;
            padding: 10px 12px;
            text-align: left;
            font-size: 1em;
        }
        .laporan-table th {
            background: #ffe0e0;
        }
        .laporan-table tr:nth-child(even) {
            background: #f9f9f9;
        }
        @media (max-width: 900px) {
            .main-container { flex-direction: column; }
            .sidebar { width: 100%; flex-direction: row; }
            .content { padding: 15px; }
        }
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
                <li onclick="window.location.href='Entry_Karyawan(Adm).php'">Entry Karyawan</li>
                <li onclick="window.location.href='daftar_hadir.php'">Daftar Hadir</li>
                <li class="active" onclick="window.location.href='laporan.php'">Laporan</li>
                <li onclick="window.location.href='Logout.php'">Logout</li>
            </ul>
        </div>
        <div class="content">
            <div class="laporan-title">Laporan Absensi</div>
            <table class="laporan-table">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Keterangan</th>
                </tr>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($query)) {
                    echo '<tr>';
                    echo '<td>' . $no++ . '</td>';
                    echo '<td>' . htmlspecialchars($row['nama']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['tanggal']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['jam_masuk']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['jam_keluar']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['keterangan']) . '</td>';
                    echo '</tr>';
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html> 