<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include 'header.php';
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = $_SESSION['UserID'];
    $deviceType = $conn->real_escape_string($_POST['device-type']);
    $description = $conn->real_escape_string($_POST['issue-details']);
    $deviceLocation = $conn->real_escape_string($_POST['device-location']);

    $conn->query("INSERT INTO device (DeviceType) VALUES ('$deviceType')");
    $deviceID = $conn->insert_id;

    $sql = "INSERT INTO maintenance_requset (UserID, DeviceID, Description, DeviceLocation, Status, DateCreated) 
            VALUES ($userID, $deviceID, '$description', '$deviceLocation', 'قيد التنفيذ', CURDATE())";

    if ($conn->query($sql)) {
        header("Location: upkeep.php");
        exit();
    } else {
        echo "<script>alert('حدث خطأ: " . $conn->error . "')</script>";
    }
    $conn->close();
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