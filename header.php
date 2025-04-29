<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

include 'conn.php';
$userID = $_SESSION['UserID'];
$query = $conn->query("SELECT * FROM user WHERE UserID = $userID");
$user = $query->fetch_assoc();
$conn->close();
?>

<div style="display: flex; align-items: center; justify-content: space-between; padding: 15px 30px; background: linear-gradient(90deg, #1e3c72, #2a5298); color: white; font-family: 'Tajawal', sans-serif;">
    <div style="display: flex; align-items: center; gap: 15px;">
        <img src="images/users/<?= $user['image'] ?? 'default.png' ?>" alt="Profile" style="width: 50px; height: 50px; border-radius: 50%; border: 2px solid white;">
        <div>
            <div style="font-size: 18px;">مرحباً، <strong><?= $user['FirstName'] . ' ' . $user['LastName'] ?></strong></div>
            <div style="font-size: 14px;">الدور: <?= $user['Role'] == 0 ? 'مشرف' : 'مستخدم' ?></div>
        </div>
    </div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <button onclick="history.back()" style="padding: 8px 16px; background: #ffc107; border: none; border-radius: 5px; cursor: pointer;">رجوع</button>
        <a href="logout.php" style="padding: 8px 16px; background: #dc3545; color: white; text-decoration: none; border-radius: 5px;">تسجيل الخروج</a>
    </div>
</div>