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
    <title>Entry Karyawan - INFOMEDIA</title>
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
            padding: 30px;
        }
        .form-entry {
            margin-bottom: 30px;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            background: #fafafa;
            max-width: 400px;
        }
        .form-entry h4 {
            margin-top: 0;
        }
        .form-entry label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-entry input[type="text"] {
            width: 95%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-entry input[type="submit"] {
            padding: 8px 20px;
            background: #f55;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-entry input[type="submit"]:hover {
            background: #d44;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }
        th, td {
            border: 1px solid #bbb;
            padding: 8px 10px;
            text-align: left;
        }
        th {
            background: #ffe0e0;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
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
                <li onclick="window.location.href='Entry_Karyawan.php'">📋 Entry Karyawan</li>
                <li onclick="window.location.href='#'">📅 Daftar Hadir</li>
                <li onclick="window.location.href='#'">📊 Laporan</li>
                <li onclick="window.location.href='Logout.php'">⏻ Logout</li>
            </ul>
        </div>
        <div class="content">
            <div class="form-entry">
                <h4>Entry Karyawan</h4>
                <form method="post" action="">
                    <label for="id">ID</label>
                    <input type="text" id="id" name="id" required>
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" required>
                    <label for="alamat">Alamat</label>
                    <input type="text" id="alamat" name="alamat" required>
                    <input type="submit" name="simpan" value="Simpan">
                </form>
            </div>
            <h4>Daftar Karyawan</h4>
            <table>
                <tr>
                    <th>No</th>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                </tr>
                <!-- Contoh data statis, nanti bisa diganti dengan data dari database -->
                <tr>
                    <td>1</td>
                    <td>1001</td>
                    <td>NGESHA</td>
                    <td>PADALARANG</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>1502</td>
                    <td>PERSO</td>
                    <td>CIMAHI</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>3005</td>
                    <td>ISMAIL</td>
                    <td>CIWIDEY</td>
                </tr>
                <!-- Tambahkan baris lain sesuai kebutuhan -->
            </table>
        </div>
    </div>
</body>
</html>