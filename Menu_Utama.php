<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: Login.php');
    exit();
}
$username = $_SESSION['username'];
// Koneksi ke database
$connection = mysqli_connect("localhost", "root", "", "persediaan_barang");
if (!$connection) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
$query = mysqli_query($connection, "SELECT * FROM user WHERE username = '$username'");
$hasil = mysqli_fetch_assoc($query);

// Ambil statistik untuk dashboard
$total_karyawan = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as total FROM karyawan"))['total'];
$total_hadir_hari_ini = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as total FROM absensi WHERE tanggal = CURDATE() AND status = 'hadir'"))['total'];
$total_izin_hari_ini = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as total FROM absensi WHERE tanggal = CURDATE() AND status = 'izin'"))['total'];
$total_sakit_hari_ini = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as total FROM absensi WHERE tanggal = CURDATE() AND status = 'sakit'"))['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Menu Utama - INFOMEDIA</title>
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
        .dashboard-container { max-width: 1200px; margin: 0 auto; }
        .welcome-section { text-align: center; margin-bottom: 40px; padding: 30px; background: linear-gradient(135deg, #ff5555, #ff7f2a); color: white; border-radius: 10px; }
        .welcome-section h1 { margin: 0 0 10px 0; font-size: 2.5em; }
        .welcome-section p { margin: 0; font-size: 1.2em; opacity: 0.9; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .stat-card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center; border-left: 5px solid #ff5555; }
        .stat-card h3 { margin: 0 0 10px 0; color: #333; font-size: 1.1em; }
        .stat-card .number { font-size: 2.5em; font-weight: bold; color: #ff5555; margin: 10px 0; }
        .stat-card .label { color: #666; font-size: 0.9em; }
        .quick-actions { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .quick-actions h2 { margin: 0 0 20px 0; color: #333; }
        .action-buttons { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .action-btn { 
            padding: 15px 20px; 
            background: #ff5555; 
            color: white; 
            text-decoration: none; 
            border-radius: 8px; 
            text-align: center; 
            font-weight: bold; 
            transition: all 0.3s; 
            display: block;
        }
        .action-btn:hover { 
            background: #ff7f2a; 
            transform: translateY(-2px); 
            box-shadow: 0 6px 12px rgba(0,0,0,0.15); 
        }
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
            .main-container { flex-direction: column; }
            .sidebar { width: 100%; flex-direction: row; }
            .content { padding: 15px; }
            .header { font-size: 1.2em; padding: 18px 0 12px 0; }
            .welcome-section h1 { font-size: 1.8em; }
            .stats-grid { grid-template-columns: 1fr; }
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
                <li class="active"><a href="Menu_Utama.php">Menu Utama</a></li>
                <li><a href="Entry_Karyawan(Adm).php">Entry Karyawan</a></li>
                <li><a href="daftar_hadir.php">Daftar Hadir</a></li>
                <li><a href="laporan.php">Laporan</a></li>
                <li><a href="Logout.php">Logout</a></li>
            </ul>
        </div>
        <div class="content">
            <div class="dashboard-container">
                <div class="welcome-section">
                    <h1>Selamat Datang!</h1>
                    <p>Sistem Absensi Karyawan PT. Infomedia</p>
                    <p style="font-size: 1em; margin-top: 10px;">Halo, <?= htmlspecialchars($username) ?>!</p>
                </div>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <h3>Total Karyawan</h3>
                        <div class="number"><?= $total_karyawan ?></div>
                        <div class="label">Karyawan Terdaftar</div>
                    </div>
                    <div class="stat-card">
                        <h3>Hadir Hari Ini</h3>
                        <div class="number"><?= $total_hadir_hari_ini ?></div>
                        <div class="label">Karyawan Hadir</div>
                    </div>
                    <div class="stat-card">
                        <h3>Izin Hari Ini</h3>
                        <div class="number"><?= $total_izin_hari_ini ?></div>
                        <div class="label">Karyawan Izin</div>
                    </div>
                    <div class="stat-card">
                        <h3>Sakit Hari Ini</h3>
                        <div class="number"><?= $total_sakit_hari_ini ?></div>
                        <div class="label">Karyawan Sakit</div>
                    </div>
                </div>
                
                <div class="quick-actions">
                    <h2>Aksi Cepat</h2>
                    <div class="action-buttons">
                        <a href="Entry_Karyawan(Adm).php" class="action-btn">Entry Karyawan</a>
                        <a href="daftar_hadir.php" class="action-btn">Daftar Hadir</a>
                        <a href="laporan.php" class="action-btn">Laporan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 