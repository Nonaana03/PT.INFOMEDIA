<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location:login.php');
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
?>

<html>
    <head>
        <title> Aplikasi Absensi Karyawan </title>
        <link href="css/styles.css" rel="stylesheet" type="text/css" />
        <link href="images/Famatex.png" rel="shortcut icon" />
        <script type="text/javascript" language="JavaScript">
            function konfirmasi_hapus() {
                tanya = confirm("Anda Yakin Akan Menghapus Data ?");
                if (tanya == true) return true;
                else return false;
            }
            function konfirmasi_update() {
                tanya = confirm("Anda Yakin dengan ingin Meng-Update Data ?");
                if (tanya == true) return true;
                else return false;
            }
            </script>
        </head>
        <body background='images/Infomedia.jpg'>
            <div id=wrap>
                <div id=header>
                    <div id=title style='margin-top:5px'>Absensi Karyawan PT. Infomedia</div>
        </div>
        <div id=sidebar>
            <div id=title_side> MENU PILIHAN </div>
            <a href='Menu_Utama.php'><div id=menu>Menu Utama</div></a>
            <a href='Entry_Karyawan(Adm).php'><div id=menu>Entry Karyawan</div></a>
            <a href='daftar_hadir.php'><div id=menu>Daftar Hadir</div></a>
            <a href='laporan.php'><div id=menu>Laporan</div></a>
            <a href='logout.php'><div id=menu>Logout</div></a> 
        </div>
        <div id=contect>
            <?php
            // include("page.php");
            ?>
        </div>
        </body>
        </html>