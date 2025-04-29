<?php
session_start();
include 'conn.php';
include 'header.php';

// التحقق من تسجيل الدخول
if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

$UserID = $_SESSION['UserID'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deviceType = $_POST['device-type'];
    $description = $_POST['issue-details'];
    $deviceLocation = $_POST['device-location'];
    $status = 'قيد التنفيذ';
    $dateCreated = date('Y-m-d');

    // إدخال الجهاز إلى جدول device أولاً
    $stmtDevice = $conn->prepare("INSERT INTO device (DeviceType) VALUES (?)");
    $stmtDevice->bind_param("s", $deviceType);
    $stmtDevice->execute();
    $deviceID = $stmtDevice->insert_id;

    // إدخال الطلب إلى جدول maintenance_requset
    $stmt = $conn->prepare("INSERT INTO maintenance_requset (UserID, DeviceID, Description, DeviceLocation, Status, DateCreated) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissss", $UserID, $deviceID, $description, $deviceLocation, $status, $dateCreated);

    if ($stmt->execute()) {
        header("Location: upkeep.php");
        exit();
    } else {
        echo "<p style='color:red;'>خطأ أثناء إضافة الطلب: " . $stmt->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>طلب صيانة أجهزة الكلية</title>
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background: #1e3c72;
            color: white;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            margin-top: 50px;
            background: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 10px;
            display: inline-block;
            width: 90%;
            max-width: 600px;
        }
        .title {
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #ffcc00;
        }
        .form-group {
            margin: 15px 0;
            text-align: right;
        }
        label {
            display: block;
        }
        input, textarea, select, button {
            padding: 12px;
            width: 100%;
            margin-top: 5px;
            border-radius: 5px;
            border: none;
        }
        button {
            background: linear-gradient(45deg, #28a745, #218838);
            color: white;
            font-size: 18px;
            cursor: pointer;
        }
        button:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">طلب صيانة أجهزة الكلية</h1>
        <form method="post">
            <div class="form-group">
                <label for="device-type">نوع الجهاز:</label>
                <select id="device-type" name="device-type" required>
                    <option value="لابتوب">لابتوب</option>
                    <option value="جهاز كمبيوتر">جهاز كمبيوتر</option>
                </select>
            </div>
            <div class="form-group">
                <label for="device-location">موقع الجهاز:</label>
                <input type="text" id="device-location" name="device-location" required>
            </div>
            <div class="form-group">
                <label for="issue-details">تفاصيل المشكلة:</label>
                <textarea id="issue-details" name="issue-details" rows="4" required></textarea>
            </div>
            <button type="submit">إرسال الطلب</button>
        </form>
    </div>
</body>
</html>
