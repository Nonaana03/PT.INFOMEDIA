<?php
session_start();
if(!isset($_SESSION['username'])) {
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
        <link href='css/styles.css' rel='stylesheet' type='text/css'/>
        <script type="text/javascript" language="Javascript"> function konfirmasi_hapus() 
            {
                tanya = confirm("Anda Yakin Akan Menghapus Data ?");
                if (tanya == true ) return true;
                else return false;
            }
            function konfirmasi_update()
            {
                tanya = confirm("Anda Yakin dengan ingin Meng-update Data ?");
                if (tanya == true ) return true;
                else return false;
            }
            </script>
    </head>
    <body background='images/Famatex.jpg'>
        <div id=warp>
            <div id=header>
                <div id=title style='margin-top:5px'>Absensi Karyawan PT. INFOMEDIA</div>
                <a href='?p=laporan'><div id=menu>Logout</div></a>
            </div>
            <div id=conect>
                <!-- Konten utama di sini -->
            </div>
        </div>
    </body>
</html>
