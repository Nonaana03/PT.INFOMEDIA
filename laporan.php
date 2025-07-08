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
$query = mysqli_query($connection, "
    SELECT 
        k.nama, 
        a.tanggal, 
        MIN(a.jam) as jam_masuk, 
        MAX(a.jam) as jam_keluar,
        (SELECT keterangan FROM absensi WHERE id_karyawan = a.id_karyawan AND tanggal = a.tanggal ORDER BY jam ASC LIMIT 1) as keterangan
    FROM absensi a 
    LEFT JOIN karyawan k ON a.id_karyawan = k.id 
    GROUP BY a.tanggal, a.id_karyawan 
    ORDER BY a.tanggal DESC, k.nama ASC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Absensi - INFOMEDIA</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            border: none;
        }
        .header {
            background: #ff5555;
            color: #fff;
            padding: 30px 0 20px 0;
            text-align: center;
            font-size: 2em;
            font-weight: bold;
            letter-spacing: 2px;
            margin-bottom: 0;
            border-radius: 0;
            border: none;
            overflow: hidden;
        }
        .main-container {
            display: flex;
            align-items: flex-start;
            margin-top: 0;
            padding: 0;
        }
        .sidebar {
            background: #ff7f2a;
            color: #fff;
            width: 220px;
            padding: 0;
            margin: 8px 0 0 0;
            display: flex;
            flex-direction: column;
            align-items: stretch;
            border-top: none;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        }
        .sidebar-menu {
            flex: 1;
            padding: 0;
            margin: 0;
            list-style: none;
        }
        .sidebar-menu li {
            padding: 15px 30px 15px 18px;
            border-bottom: 1px solid #fff3;
            cursor: pointer;
            font-size: 1.05em;
            font-weight: bold;
            transition: background 0.2s;
            text-align: left;
            display: flex;
            align-items: center;
        }
        .sidebar-menu li:hover, .sidebar-menu .active {
            background: #ff9f5a;
        }
        .sidebar-menu .menu-utama {
            background: #ff5555 !important;
            color: #fff;
        }
        .sidebar-menu .menu-utama a {
            color: #fff !important;
        }
        .sidebar-menu .menu-utama:hover {
            background: #ff5555 !important;
        }
        .sidebar-menu a {
            color: inherit;
            text-decoration: none;
            display: flex;
            align-items: center;
            width: 100%;
            height: 100%;
        }
        .sidebar-menu .icon {
            margin-right: 10px;
            font-size: 1.1em;
        }
        .content {
            flex: 1;
            background: #fff;
            padding: 40px 30px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }
        .content-box {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            max-width: 1200px;
            width: 100%;
            padding: 32px 28px;
            margin: 0 auto;
            border: 2px solid #222;
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
        .sidebar-menu .logout {
            border-radius: 0 !important;
        }
        .sidebar-menu .logout a {
            border-radius: 0 !important;
        }
        @media (max-width: 900px) {
            .main-container { flex-direction: column; }
            .sidebar { width: 100%; flex-direction: row; }
            .content { padding: 15px; }
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
                <li class="menu-utama"><a href="Menu_Utama.php"><span class="icon">🏠</span>Menu Utama</a></li>
                <li><a href="Entry_Karyawan(Adm).php"><span class="icon">👤</span>Entry Karyawan</a></li>
                <li><a href="daftar_hadir.php"><span class="icon">🗓️</span>Daftar Hadir</a></li>
                <li class="active"><a href="laporan.php"><span class="icon">📄</span>Laporan</a></li>
                <li class="logout"><a href="Logout.php"><span class="icon">🚪</span>Logout</a></li>
            </ul>
        </div>
        <div class="content">
            <div class="content-box">
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
    </div>
</body>
</html> 