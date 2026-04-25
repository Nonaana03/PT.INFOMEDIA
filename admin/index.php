<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../Login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - INFOMEDIA</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f7f7f7; margin: 0; }
        .admin-container { max-width: 500px; margin: 80px auto; background: #fff; border-radius: 8px; box-shadow: 0 4px 24px rgba(0,0,0,0.08); padding: 40px 30px; text-align: center; }
        h2 { color: #ff5555; margin-bottom: 20px; }
        .btn { display: inline-block; margin-top: 20px; padding: 10px 24px; background: #ff7f2a; color: #fff; border: none; border-radius: 4px; font-size: 1em; cursor: pointer; text-decoration: none; }
        .btn:hover { background: #ff9f5a; color: #fff; }
    </style>
</head>
<body>
    <div class="admin-container">
        <h2>Selamat Datang di Halaman Admin</h2>
        <p>Anda login sebagai <b><?php echo htmlspecialchars($_SESSION['username']); ?></b></p>
        <a href="../Dashboard.php" class="btn">Kembali ke Dashboard</a>
    </div>
</body>
</html> 