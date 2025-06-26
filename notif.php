<?php
// notif.php
if (isset($_SESSION['notif'])) {
    echo '<div style="padding:10px;margin-bottom:10px;border-radius:5px;'.
        ($_SESSION['notif_type']==='success' ? 'background:#d4edda;color:#155724;border:1px solid #c3e6cb;' : 'background:#f8d7da;color:#721c24;border:1px solid #f5c6cb;').
        '">'.htmlspecialchars($_SESSION['notif']).'</div>';
    unset($_SESSION['notif']);
    unset($_SESSION['notif_type']);
} 