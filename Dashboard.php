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
    <title>Absensi Karyawan PT. INFOMEDIA</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f7f7f7;
        }
        .header {
            background: #f55;
            color: #fff;
            padding: 30px 0 20px 0;
            text-align: center;
            font-size: 2em;
            font-weight: bold;
            letter-spacing: 2px;
        }
        .container {
            display: flex;
            margin: 0 auto;
            max-width: 1100px;
            min-height: 80vh;
        }
        .sidebar {
            background: #ff7f2a;
            color: #fff;
            width: 250px;
            padding: 20px 0;
        }
        .sidebar h3 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 1.2em;
            letter-spacing: 1px;
        }
        .menu {
            list-style: none;
            padding: 0;
        }
        .menu li {
            padding: 15px 30px;
            border-bottom: 1px solid #fff3;
            cursor: pointer;
            display: flex;
            align-items: center;
        }
        .menu li:hover {
            background: #ff9f5a;
        }
        .menu li:last-child {
            color: #ffb3b3;
        }
        .content {
            flex: 1;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .logo {
            text-align: center;
        }
        .logo img {
            width: 180px;
            margin-bottom: 20px;
        }
        .logo h1 {
            color: #d44;
            font-size: 2em;
        }
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
                <li>📅 Daftar Hadir</li>
                <li>📊 Laporan</li>
                <li onclick="window.location.href='Logout.php'">⏻ Logout</li>
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