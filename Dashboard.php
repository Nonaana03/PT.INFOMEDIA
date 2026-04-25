<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: Login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - INFOMEDIA</title>
    <link href="css/styles.css" rel="stylesheet" type="text/css" />
    <style>
        .main-container { display: flex; min-height: 100vh; }
        .sidebar { background: #ff7f2a; color: #fff; width: 220px; padding: 0; display: flex; flex-direction: column; align-items: stretch; }
        .sidebar-header { background: #ff5555; padding: 30px 10px 20px 10px; text-align: center; font-size: 1.4em; font-weight: bold; letter-spacing: 2px; line-height: 1.2; }
        .sidebar-menu { flex: 1; padding: 0; margin: 0; list-style: none; }
        .sidebar-menu li { padding: 18px 25px; border-bottom: 1px solid #fff3; cursor: pointer; font-size: 1.1em; font-weight: bold; transition: background 0.2s; }
        .sidebar-menu li:hover, .sidebar-menu .active { background: #ff9f5a; }
        .content { flex: 1; background: #fff; padding: 40px 30px; display: flex; align-items: center; justify-content: center; }
        .logo { text-align: center; }
        .logo img { width: 180px; margin-bottom: 20px; }
        .logo h1 { color: #d44; font-size: 2em; }
        @media (max-width: 900px) { .main-container { flex-direction: column; } .sidebar { width: 100%; flex-direction: row; } .content { padding: 15px; } }
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
    <div class="main-container">
        <div class="sidebar">
            <div class="sidebar-header">
                ABSENSI KARYAWAN PT. INFOMEDIA
                <div style="font-size:0.7em;font-weight:normal;margin-top:4px;">Jl. Terusan Buahbatu No. 33</div>
            </div>
            <ul class="sidebar-menu">
                <li><a href="Dashboard.php">Dashboard</a></li>
                <li><a href="Entry_Karyawan(Adm).php">Entry Karyawan</a></li>
                <li><a href="daftar_hadir.php">Daftar Hadir</a></li>
                <li><a href="laporan.php">Laporan</a></li>
                <li><a href="Logout.php">Logout</a></li>
            </ul>
        </div>
        <div class="content">
            <div class="logo">
                <img src="infomedia.png" alt="infomedia" style="width: 180px; margin-bottom: 20px;">
                <h1>infomedia</h1>
                <div>by Telkom Indonesia</div>
            </div>
        </div>
    </div>
</body>
</html> 