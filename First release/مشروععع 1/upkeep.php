<?php
session_start();
include 'conn.php';
include 'header.php';

$UserID = $_SESSION['UserID'];
$Role = $_SESSION['Role'];

$sql = ($Role == 0)
    ? "SELECT maintenance_requset.*, user.Name, device.DeviceType 
       FROM maintenance_requset 
       JOIN user ON maintenance_requset.UserID = user.UserID
       JOIN device ON maintenance_requset.DeviceID = device.DeviceID"
    : "SELECT maintenance_requset.*, user.Name, device.DeviceType 
       FROM maintenance_requset 
       JOIN user ON maintenance_requset.UserID = user.UserID 
       JOIN device ON maintenance_requset.DeviceID = device.DeviceID
       WHERE maintenance_requset.UserID = $UserID";

$query = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>طلبات الصيانة</title>
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
            margin-top: 30px;
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 15px;
            display: inline-block;
            width: 90%;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
        }
        .title {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #ffcc00;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.1);
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        th {
            background: linear-gradient(45deg, #4a148c, #7b1fa2);
            color: white;
        }
        .pending { background-color: #ffc107; color: black; font-weight: bold; }
        .completed { background-color: #28a745; font-weight: bold; }
        .cancelled { background-color: #dc3545; font-weight: bold; }
        select, button {
            padding: 5px;
            border-radius: 5px;
            margin-top: 5px;
        }
        .delete-btn {
            background-color: #e53935;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color: #c62828;
        }
    </style>
    <script>
        function confirmDelete(requestId) {
            if (confirm("هل أنت متأكد أنك تريد حذف هذا الطلب؟")) {
                window.location.href = "delete_request.php?id=" + requestId;
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1 class="title">طلبات الصيانة</h1>
        <table>
            <tr>
                <th>رقم الطلب</th>
                <?php if($Role == 0) echo "<th>اسم المستخدم</th>"; ?>
                <th>نوع الجهاز</th>
                <th>موقع الجهاز</th>
                <th>الوصف</th>
                <th>تاريخ الإنشاء</th>
                <th>تاريخ الإصلاح</th>
                <th>الحالة</th>
                <?php if($Role == 0) echo "<th>تعديل</th><th>حذف</th>"; ?>
            </tr>
            <?php while($row = $query->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['RequsetID'] ?></td>
                    <?php if($Role == 0): ?>
                        <td><?= $row['Name'] ?></td>
                    <?php endif; ?>
                    <td><?= $row['DeviceType'] ?></td>
                    <td><?= $row['DeviceLocation'] ?></td>
                    <td><?= $row['Description'] ?></td>
                    <td><?= $row['DateCreated'] ?></td>
                    <td><?= $row['DateResolved'] ?: '-' ?></td>
                    <td class="<?= $row['Status'] == 'تم الإصلاح' ? 'completed' : ($row['Status'] == 'تم الإلغاء' ? 'cancelled' : 'pending') ?>">
                        <?= $row['Status'] ?>
                    </td>
                    <?php if($Role == 0): ?>
                        <td>
                            <form method="post" action="update_status.php">
                                <input type="hidden" name="request_id" value="<?= $row['RequsetID'] ?>">
                                <select name="status">
                                    <option value="قيد التنفيذ" <?= $row['Status'] == 'قيد التنفيذ' ? 'selected' : '' ?>>قيد التنفيذ</option>
                                    <option value="تم الإصلاح" <?= $row['Status'] == 'تم الإصلاح' ? 'selected' : '' ?>>تم الإصلاح</option>
                                    <option value="تم الإلغاء" <?= $row['Status'] == 'تم الإلغاء' ? 'selected' : '' ?>>تم الإلغاء</option>
                                </select>
                                <button type="submit">تحديث</button>
                            </form>
                        </td>
                        <td><button class="delete-btn" onclick="confirmDelete(<?= $row['RequsetID'] ?>)">حذف</button></td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
