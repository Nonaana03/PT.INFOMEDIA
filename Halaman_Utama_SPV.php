<?php
    include("../conn.php");
?>
<?php session_strat();
if(!isset($_SESSION['username'])) {
    header('location:login.php') ;
}
else {
    $username = $_SESSION['username'];
}
require_once("../koneksi.php");
$query = mysql_query("SELECT * FROM user WHERE username = '$username'");
$hasil = mysql_fetch_array_($query);
?>

<html>
    <head>
        <title> Aplikasi Absensi Karyawan </title>
        <link href='../css/style.css' rel='stylesheet' type='text/css'/>
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
                    <body background = 'images/Famatex.jpg'>
                    <div id=warp>
                        <div id=header>
                            <div id=title style='margin-top:5 px'> Absensi Karyawanta PT. INFOMEDIA </div>
                            <a herf='?p=laporan'><div id=menu><img src='../images/khs.png' width=25 hright=25 align=left style='margin-right:10px> Logout </div></a>
                            </div>
                            <div id=conect>
                            <?php
                                include("page.php");
                            ?>
            </div>
            </body>
            </html>
