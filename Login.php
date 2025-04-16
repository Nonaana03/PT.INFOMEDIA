<?php
session_start(); // Memulai session
$error=''; //Variabel untuk menyimpan pesan error
if (isset($_POST ['simpan'])) {
    if (empty($_POST['username']) ||
empty ($_POST['password'])) {
    echo "Username or Password tidak boleh kosong";
}
else {
    // Variabel username dan password
    $username = $_POST['username'];
    $password = $_POST['password'];

    //Membangun koneksi ke database
    $connection = mysql_connect ("localhost", "root", "");

    // Mencegah MySQL injection
    $username = stripslashes($username);
    $password = stripslashes($password);
    $username = mysql_real_escape_string($username);
    $password = mysql_real_escape_string($password);

    // Seleksi Database
    $db = mysql_select_db("persediaan_barang", $connection);

    // SQL query untuk memeriksa apakah user terdapat di database?
    $query = mysql_query("select * from user where username='$username' AND password='$password'", $connection);
    $posisi = mysql_fetch_array_(mysql_query("select posisi from user where username='$username' AND password='$password'", $connection));
    if ($posisi[0]=="admin") {
        $rows = mysql_num_rows($query);
        if ($rows ==1) {
            $_SESSION['username']=$_username; // Membuat session
            header("location: admin/index.php"); // Mengarahkan ke halaman welcome
        }
        else {
            echo "Username atau Password belum terdaftar";
        }
        mysql_close($connection); // Menutup koneksi
    }
    
}
if ($posisi[0]=="manager"){
    $rows = mysql_num_rows($query);
    if ($rows ==1) {
        $_SESSION['username']=$usernmae; // Membuat session
        header("location: manager/idex.php"); // Mengarah ke halaman welcome
    }
    else {
        echo "Username atau Password belum terdaftar";
    }
    mysql_close($connection); // Menutup koneksi
}
}
?>