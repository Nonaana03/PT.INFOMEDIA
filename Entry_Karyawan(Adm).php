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
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar-menu li {
            font-size: 1.15em;
            font-weight: bold;
            padding: 18px 25px;
            border-bottom: 1px solid #fff3;
            cursor: pointer;
            transition: background 0.2s;
            text-align: left;
        }
        .sidebar-menu li:hover {
            background: #ff9f5a;
        }
        .sidebar-menu li:last-child {
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
        .sidebar-header {
            font-size: 1.3em;
            font-weight: bold;
            text-align: left;
            padding: 30px 25px 10px 25px;
            letter-spacing: 1px;
            line-height: 1.2;
        }
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
        <div class="sidebar">
            <div class="sidebar-header">
                ABSENSI KARYAWAN PT. INFOMEDIA
                <div style="font-size:0.7em;font-weight:normal;margin-top:4px;">Jl. Terusan Buahbatu No. 33</div>
            </div>
            <ul class="sidebar-menu">
                <li><a href="Entry_Karyawan(Adm).php">Entry Karyawan</a></li>
                <li><a href="daftar_hadir.php">Daftar Hadir</a></li>
                <li><a href="laporan.php">Laporan</a></li>
                <li><a href="Logout.php">Logout</a></li>
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