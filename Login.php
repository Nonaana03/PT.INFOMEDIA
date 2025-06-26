<?php
session_start(); // Memulai session
$error = ''; // Variabel untuk menyimpan pesan error
if (isset($_POST['simpan'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
    echo "Username or Password tidak boleh kosong";
    } else {
    // Variabel username dan password
    $username = $_POST['username'];
    $password = $_POST['password'];

        // Membangun koneksi ke database
        $connection = mysqli_connect("localhost", "root", "", "persediaan_barang");
        if (!$connection) {
            die("Koneksi gagal: " . mysqli_connect_error());
        }

    // Mencegah MySQL injection
        $username = mysqli_real_escape_string($connection, stripslashes($username));
        $password = mysqli_real_escape_string($connection, stripslashes($password));

    // SQL query untuk memeriksa apakah user terdapat di database?
        $query = mysqli_query($connection, "SELECT * FROM user WHERE username='$username' AND password='$password'");
        $user = mysqli_fetch_assoc($query);

        if ($user) {
            $_SESSION['username'] = $username; // Membuat session
            $posisi = $user['posisi'];
            if ($posisi == "admin") {
                header("Location: admin/index.php");
                exit();
            } elseif ($posisi == "manager") {
                header("Location: manager/index.php");
                exit();
            } else {
                echo "Posisi user tidak dikenali.";
            }
        } else {
            echo "Username atau Password belum terdaftar";
        }
        mysqli_close($connection); // Menutup koneksi
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
