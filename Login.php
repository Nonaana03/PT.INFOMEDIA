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
<!-- HTML & CSS untuk tampilan login modern -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - INFOMEDIA</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: #3a3a3a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, Helvetica, sans-serif;
        }
        .login-container {
            background: #fff;
            padding: 40px 30px 30px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.2);
            min-width: 320px;
            text-align: center;
        }
        .login-container h2 {
            margin-bottom: 24px;
            font-size: 2em;
            letter-spacing: 2px;
        }
        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
        }
        .login-container input[type="submit"] {
            width: 95%;
            padding: 10px;
            background: #e0e0e0;
            border: none;
            border-radius: 4px;
            font-size: 1em;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.2s;
        }
        .login-container input[type="submit"]:hover {
            background: #bdbdbd;
        }
    </style>
</head>
<body>
    <form class="login-container" method="post" action="">
        <h2>INFOMEDIA</h2>
        <input type="text" name="username" placeholder="username" autocomplete="off" required>
        <input type="password" name="password" placeholder="password" required>
        <input type="submit" name="simpan" value="Login">
    </form>
</body>
</html>
