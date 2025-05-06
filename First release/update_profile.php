<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profileImage'])) {
    $userID = $_SESSION['UserID'];
    
    // حذف الصورة القديمة
    $oldImage = $conn->query("SELECT image FROM user WHERE UserID = $userID")->fetch_assoc()['image'];
    if ($oldImage != 'default.png') {
        @unlink('images/users/' . $oldImage);
    }

    // رفع الصورة الجديدة
    $imageName = 'default.png';
    if ($_FILES['profileImage']['error'] == 0) {
        $allowed = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['profileImage']['type'], $allowed)) {
            $ext = pathinfo($_FILES['profileImage']['name'], PATHINFO_EXTENSION);
            $imageName = uniqid() . '_user.' . $ext;
            move_uploaded_file($_FILES['profileImage']['tmp_name'], 'images/users/' . $imageName);
        }
    }

    $conn->query("UPDATE user SET image = '$imageName' WHERE UserID = $userID");
    $_SESSION['image'] = $imageName;
    header("Location: " . ($_SESSION['Role'] == 0 ? "admin_home.php" : "user_home.php"));
    exit();
}
?>