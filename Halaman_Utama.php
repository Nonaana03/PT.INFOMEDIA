<?php
    include('../conn.php');
?>
<?php session_start();
if (!isset($_SESSION['username'])) {
    header('location:login.php');
}
else {
    $username = $_SESSION['username'];
}
require_once('../koneksi.php');
$query = mysql_query("SELECT * FROM user WHERE username = '$username'");
$hasil = mysql_fetch_array_($query);
?>

<html>
    <head>
        <title> Aplikasi Absensi Karyawan </title>
        <link href='../css/styles.css' rel='stylesheet' type='text/css' />
        <link href='../css/images/Famatex.png' rel='shortcut icon' />
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
            <a href='?p=entry_karyawan '><div id=menu><img src='../images/khs.png' width=25 height=25 align=left style='margin-right:10px'> Entry Karyawan</div></a>
            <a href='?p=penerimaan '><div id=menu><img src='../images/khs.png' width= 25 height=25 align=left style='margin-right:10px'> Daftar Hadir </div></a>
            <a href='?p=laporan '><div id=menu><img src='../images/khs.png' width= 25 height=25 align=left style='margin-right:10px'> Laporan </div></a>
            <a href='../logout.php'><div id=menu><img src='../images/logout.png' width=25 height=25 align=left style='margin-right:10px'> Logout </div></a> 
        </div>
        <div id=contect>
            <?php
            include("page.php")

            ?>

        </div>
        </body>
        </html>