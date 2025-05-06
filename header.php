<?php
if (session_status() == PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

$profileImage = ($_SESSION['Role'] == 0) ? 'images/admin.png' : 'images/default.png';
$homePage = ($_SESSION['Role'] == 0) ? 'admin_home.php' : 'user_home.php';
?>

<div style="display: flex; align-items: center; justify-content: space-between; padding: 15px 30px; background: linear-gradient(90deg, #1e3c72, #2a5298); color: white; font-family: 'Tajawal', sans-serif;">
    <div style="display: flex; align-items: center; gap: 15px;">
        <img src="<?= $profileImage ?>" 
             style="width: 50px; height: 50px; border-radius: 50%; border: 2px solid white; object-fit: cover;">
        <div>
            <div style="font-size: 18px;">مرحباً، <strong><?= $_SESSION['FirstName'] . ' ' . $_SESSION['LastName'] ?></strong></div>
            <div style="font-size: 14px;">الدور: <?= ($_SESSION['Role'] == 0) ? "مشرف" : "مستخدم" ?></div>
        </div>
    </div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <a href="<?= $homePage ?>" style="padding: 8px 16px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">
            <i class="fas fa-home"></i> الرئيسية
        </a>
        <button onclick="history.back()" style="padding: 8px 16px; background: #ffc107; border: none; border-radius: 5px; cursor: pointer;">
            <i class="fas fa-arrow-left"></i> رجوع
        </button>
        <a href="Home.php" style="padding: 8px 16px; background: #dc3545; color: white; text-decoration: none; border-radius: 5px;">
            <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
        </a>
    </div>
</div>