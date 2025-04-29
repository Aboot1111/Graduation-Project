<?php
session_start();
include 'conn.php';
include 'header.php';

// تأكد أنه فقط الأدمن يقدر يدخل الصفحة
if ($_SESSION['Role'] != 0) {
    header("Location: user_home.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>الرئيسية - الأدمن</title>
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
            background: #ff9800;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            color: white;
            transition: 0.3s;
        }
        .btn:hover {
            background: #e65100;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>لوحة تحكم فني الصيانة في الكلية</h1>
        <a class="btn" href="upkeep.php">عرض جميع طلبات الصيانة</a>
        <a class="btn" href="maintenance1_request.php">ارسال طلب صيانة</a>
    </div>
</body>
</html>
