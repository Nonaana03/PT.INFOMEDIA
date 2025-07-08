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
$error = '';
// Proses simpan data
if (isset($_POST['simpan'])) {
    $id = mysqli_real_escape_string($connection, $_POST['id']);
    // Cek apakah ID sudah ada
    $cek = mysqli_query($connection, "SELECT id FROM karyawan WHERE id='$id'");
    if (mysqli_num_rows($cek) > 0) {
        $error = "ID sudah terdaftar!";
    } else {
        $nama = mysqli_real_escape_string($connection, $_POST['nama']);
        $alamat = mysqli_real_escape_string($connection, $_POST['alamat']);
        $jabatan = mysqli_real_escape_string($connection, $_POST['jabatan']);
        $keterangan = mysqli_real_escape_string($connection, $_POST['keterangan']);
        mysqli_query($connection, "INSERT INTO karyawan (id, nama, alamat, jabatan, keterangan) VALUES ('$id', '$nama', '$alamat', '$jabatan', '$keterangan')");
        header("Location: Entry_Karyawan(Adm).php");
        exit();
    }
}
// Proses hapus data
if (isset($_GET['hapus'])) {
    $id = mysqli_real_escape_string($connection, $_GET['hapus']);
    mysqli_query($connection, "DELETE FROM karyawan WHERE id='$id'");
    header("Location: Entry_Karyawan(Adm).php");
    exit();
}
// Proses edit data
$edit_data = null;
if (isset($_GET['edit'])) {
    $id = mysqli_real_escape_string($connection, $_GET['edit']);
    $result = mysqli_query($connection, "SELECT * FROM karyawan WHERE id='$id'");
    $edit_data = mysqli_fetch_assoc($result);
}
if (isset($_POST['update'])) {
    $id = mysqli_real_escape_string($connection, $_POST['id']);
    $nama = mysqli_real_escape_string($connection, $_POST['nama']);
    $alamat = mysqli_real_escape_string($connection, $_POST['alamat']);
    $jabatan = mysqli_real_escape_string($connection, $_POST['jabatan']);
    $keterangan = mysqli_real_escape_string($connection, $_POST['keterangan']);
    mysqli_query($connection, "UPDATE karyawan SET nama='$nama', alamat='$alamat', jabatan='$jabatan', keterangan='$keterangan' WHERE id='$id'");
    header("Location: Entry_Karyawan(Adm).php");
    exit();
}
// Ambil data karyawan
$karyawan = mysqli_query($connection, "SELECT * FROM karyawan ORDER BY id ASC");
// Ambil data tanggal absensi (7 hari terakhir)
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
    <title>Entry Karyawan - INFOMEDIA</title>
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
        .entry-box { border: 2px solid #bbb; border-radius: 4px; background: #fff; padding: 20px 30px 30px 30px; max-width: 700px; margin: 0 auto; }
        .entry-box h3 { margin-top: 0; font-size: 1.2em; }
        .entry-form label { display: inline-block; width: 70px; margin-bottom: 8px; }
        .entry-form input[type="text"], .entry-form select { width: 200px; padding: 5px; margin-bottom: 10px; border: 1px solid #bbb; border-radius: 3px; }
        .entry-form select { width: 210px; }
        .entry-form input[type="submit"] { padding: 5px 18px; background: #ff5555; color: #fff; border: none; border-radius: 3px; font-weight: bold; cursor: pointer; }
        .entry-form input[type="submit"]:hover { background: #ff7f2a; }
        .karyawan-table { width: 100%; border-collapse: collapse; margin-top: 18px; }
        .karyawan-table th, .karyawan-table td { border: 1px solid #bbb; padding: 7px 5px; text-align: center; font-size: 1em; }
        .karyawan-table th { background: #ffe0e0; }
        .karyawan-table tr:nth-child(even) { background: #f9f9f9; }
        .karyawan-table td.nama, .karyawan-table th.nama { text-align: left; }
        .karyawan-table td.alamat, .karyawan-table th.alamat { text-align: left; }
        .karyawan-table td.jabatan, .karyawan-table th.jabatan { text-align: left; }
        .karyawan-table td.keterangan, .karyawan-table th.keterangan {
            text-align: left !important;
            min-width: 200px;
            max-width: none;
            white-space: normal;
            word-break: break-word;
        }
        .option-btn {
            padding: 2px 10px;
            border: 1px solid #bbb;
            border-radius: 3px;
            font-size: 0.95em;
            cursor: pointer;
            margin: 0 2px;
            background: #f5f5f5;
            color: #222;
            transition: background 0.2s, color 0.2s;
            font-family: inherit;
        }
        .option-btn:hover {
            background: #e0e0e0;
            color: #000;
        }
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
                <li class="active"><a href="Entry_Karyawan(Adm).php">Entry Karyawan</a></li>
                <li><a href="daftar_hadir.php">Daftar Hadir</a></li>
                <li><a href="laporan.php">Laporan</a></li>
                <li><a href="Logout.php">Logout</a></li>
            </ul>
        </div>
        <div class="content">
            <div class="entry-box">
                <h3>Entry Karyawan</h3>
                <?php if ($error): ?>
                    <div style="color:#fff;background:#ff5555;padding:8px 0;margin-bottom:10px;border-radius:4px;text-align:center;max-width:400px;margin-left:auto;margin-right:auto;">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                <form class="entry-form" method="post" action="">
                    <label for="id">ID</label>
                    <input type="text" id="id" name="id" required value="<?= $edit_data ? htmlspecialchars($edit_data['id']) : '' ?>" <?= $edit_data ? 'readonly' : '' ?>>
                    <br>
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" required value="<?= $edit_data ? htmlspecialchars($edit_data['nama']) : '' ?>">
                    <br>
                    <label for="alamat">Alamat</label>
                    <input type="text" id="alamat" name="alamat" required value="<?= $edit_data ? htmlspecialchars($edit_data['alamat']) : '' ?>">
                    <br>
                    <label for="jabatan">Jabatan</label>
                    <select id="jabatan" name="jabatan" required>
                        <?php
                        $jabatan_list = ['agent', 'leader', 'admin'];
                        $selected = $edit_data ? $edit_data['jabatan'] : '';
                        foreach ($jabatan_list as $j) {
                            echo '<option value="'.$j.'"'.($selected==$j?' selected':'').'>'.$j.'</option>';
                        }
                        ?>
                    </select>
                    <br>
                    <label for="keterangan">Keterangan</label>
                    <input type="text" id="keterangan" name="keterangan" value="<?= $edit_data ? htmlspecialchars($edit_data['keterangan']) : '' ?>">
                    <br>
                    <?php if ($edit_data): ?>
                        <input type="submit" name="update" value="Update">
                        <a href="Entry_Karyawan(Adm).php" class="option-btn hapus-btn" style="text-decoration:none;">Batal</a>
                    <?php else: ?>
                        <input type="submit" name="simpan" value="Simpan">
                    <?php endif; ?>
                </form>
                <table class="karyawan-table">
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th class="nama">Nama</th>
                        <th class="alamat">Alamat</th>
                        <th class="jabatan">Jabatan</th>
                        <th class="keterangan">Keterangan</th>
                        <th>Option</th>
                    </tr>
                    <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($karyawan)) {
                        echo '<tr>';
                        echo '<td>' . $no++ . '</td>';
                        echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                        echo '<td class="nama">' . htmlspecialchars($row['nama']) . '</td>';
                        echo '<td class="alamat">' . htmlspecialchars($row['alamat']) . '</td>';
                        echo '<td class="jabatan">' . htmlspecialchars($row['jabatan']) . '</td>';
                        echo '<td class="keterangan">' . (isset($row['keterangan']) ? htmlspecialchars($row['keterangan']) : '-') . '</td>';
                        echo '<td>';
                        echo '<form method="get" action="Entry_Karyawan(Adm).php" style="display:inline;">';
                        echo '<input type="hidden" name="edit" value="' . htmlspecialchars($row['id']) . '">';
                        echo '<button type="submit" class="option-btn">Edit</button>';
                        echo '</form>';
                        echo '<form method="get" action="Entry_Karyawan(Adm).php" style="display:inline;" onsubmit="return confirm(\'Yakin hapus data?\')">';
                        echo '<input type="hidden" name="hapus" value="' . htmlspecialchars($row['id']) . '">';
                        echo '<button type="submit" class="option-btn">Hapus</button>';
                        echo '</form>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>