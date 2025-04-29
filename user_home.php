<?php
session_start();
include 'conn.php';
include 'header.php';

if ($_SESSION['Role'] != 1) {
    header("Location: admin_home.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>الرئيسية - المستخدم</title>
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            margin-top: 100px;
        }
        h1 {
            color: #ffc107;
        }
        .btn {
            display: inline-block;
            margin: 20px;
            padding: 15px 30px;
            font-size: 18px;
            background: #03a9f4;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            color: white;
            transition: 0.3s;
        }
        .btn:hover {
            background: #0288d1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>مرحباً بك <?= $_SESSION['FirstName'] . ' ' . $_SESSION['LastName'] ?></h1>
        <a class="btn" href="maintenance1_request.php">طلب صيانة جهاز</a>
        <a class="btn" href="upkeep.php">عرض حاله طلباتي</a>
    </div>
</body>
</html>