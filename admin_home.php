<?php
session_start();
include 'conn.php';
include 'header.php';

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
            min-height: 100vh;
        }
        .container {
            padding-top: 100px;
            padding-bottom: 50px;
        }
        h1 {
            color: #ffc107;
            margin-bottom: 40px;
        }
        .btn {
            display: inline-block;
            margin: 15px;
            padding: 15px 30px;
            font-size: 18px;
            background: #ff9800;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            color: white;
            transition: 0.3s;
            min-width: 250px;
        }
        .btn:hover {
            background: #e65100;
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>لوحة تحكم فني الصيانة في الكلية</h1>
        <div>
            <a class="btn" href="upkeep.php">
                <i class="fas fa-tools"></i> عرض جميع طلبات الصيانة
            </a>
            <a class="btn" href="maintenance1_request.php">
                <i class="fas fa-plus-circle"></i> إرسال طلب صيانة
            </a>
        </div>
    </div>
</body>
</html>