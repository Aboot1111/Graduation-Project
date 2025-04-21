<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['Name']) || !isset($_SESSION['Role'])) {
    header("Location: login.php"); 
    exit;
}

$name = $_SESSION['Name'];
$role = $_SESSION['Role'] == 0 ? "مشرف" : "مستخدم";
$image = $_SESSION['Role'] == 0 ? "admin.png" : "user.png"; 
?>

<div style="display: flex; align-items: center; justify-content: space-between; padding: 15px 30px; background: linear-gradient(90deg, #1e3c72, #2a5298); color: white; font-family: 'Tajawal', sans-serif;">
    <div style="display: flex; align-items: center; gap: 15px;">
        <img src="images/<?= $image ?>" alt="Profile" style="width: 50px; height: 50px; border-radius: 50%; border: 2px solid white;">
        <div>
            <div style="font-size: 18px;">مرحباً، <strong><?= $name ?></strong></div>
            <div style="font-size: 14px;">الدور: <?= $role ?></div>
        </div>
    </div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <button onclick="history.back()" style="padding: 8px 16px; background: #ffc107; border: none; border-radius: 5px; cursor: pointer;">رجوع</button>
        <a href="logout.php" style="padding: 8px 16px; background: #dc3545; color: white; text-decoration: none; border-radius: 5px;">تسجيل الخروج</a>
    </div>
</div>
