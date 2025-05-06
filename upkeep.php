<?php
session_start();
include 'header.php';
include 'conn.php';

if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

$isAdmin = ($_SESSION['Role'] == 0);
$userID = $_SESSION['UserID'];

$sql = $isAdmin 
    ? "SELECT r.*, CONCAT(u.FirstName, ' ', u.LastName) AS UserName, d.DeviceType 
       FROM maintenance_requset r
       JOIN user u ON r.UserID = u.UserID
       JOIN device d ON r.DeviceID = d.DeviceID
       ORDER BY r.DateCreated DESC"
    : "SELECT r.*, d.DeviceType 
       FROM maintenance_requset r
       JOIN device d ON r.DeviceID = d.DeviceID
       WHERE r.UserID = $userID
       ORDER BY r.DateCreated DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلبات الصيانة</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            margin: 30px auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            width: 95%;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.1);
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            text-align: center;
        }
        th {
            background: linear-gradient(45deg, #4a148c, #7b1fa2);
            color: white;
            position: sticky;
            top: 0;
        }
        .pending { background-color: #ffc107; color: black; font-weight: bold; }
        .completed { background-color: #28a745; font-weight: bold; }
        .cancelled { background-color: #dc3545; font-weight: bold; }
        .device-image {
            max-width: 100px;
            max-height: 100px;
            border-radius: 5px;
            border: 2px solid white;
        }
        .no-requests {
            padding: 20px;
            background: rgba(0,0,0,0.2);
            border-radius: 10px;
            margin: 20px 0;
        }
        .alert {
            max-width: 600px;
            margin: 10px auto;
        }
        @media (max-width: 768px) {
            table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">طلبات الصيانة</h1>
        
        <?php if (isset($_GET['deleted'])): ?>
            <div class="alert <?= $_GET['deleted'] ? 'alert-success' : 'alert-danger' ?>">
                <?= $_GET['deleted'] ? 'تم حذف الطلب بنجاح' : 'فشل في حذف الطلب' ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['updated'])): ?>
            <div class="alert <?= $_GET['updated'] ? 'alert-success' : 'alert-danger' ?>">
                <?= $_GET['updated'] ? 'تم تحديث الحالة بنجاح' : 'فشل في تحديث الحالة' ?>
            </div>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>رقم الطلب</th>
                            <?php if($isAdmin): ?><th>اسم المستخدم</th><?php endif; ?>
                            <th>نوع الجهاز</th>
                            <th>الموقع</th>
                            <th>الوصف</th>
                            <th>صورة الجهاز</th>
                            <th>تاريخ الإنشاء</th>
                            <th>تاريخ الإصلاح</th>
                            <th>الحالة</th>
                            <?php if($isAdmin): ?><th>تعديل</th><th>حذف</th><?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['RequsetID'] ?></td>
                            <?php if($isAdmin): ?>
                            <td><?= $row['UserName'] ?></td>
                            <?php endif; ?>
                            <td><?= $row['DeviceType'] ?></td>
                            <td><?= $row['DeviceLocation'] ?></td>
                            <td><?= $row['Description'] ?></td>
                            <td>
                                <?php 
                                $imagePath = !empty($row['Deviceimage']) ? $row['Deviceimage'] : '';
                                if (!empty($imagePath) && file_exists($imagePath)) {
                                    echo '<img src="'.$imagePath.'" class="device-image" alt="صورة الجهاز">';
                                } else {
                                    echo '-';
                                }
                                ?>
                            </td>
                            <td><?= $row['DateCreated'] ?></td>
                            <td><?= $row['DateResolved'] ?: '-' ?></td>
                            <td class="<?= 
                                $row['Status'] == 'تم الإصلاح' ? 'completed' : 
                                ($row['Status'] == 'تم الإلغاء' ? 'cancelled' : 'pending') 
                            ?>">
                                <?= $row['Status'] ?>
                            </td>
                            <?php if($isAdmin): ?>
                            <td>
                                <form method="post" action="update_status.php">
                                    <input type="hidden" name="request_id" value="<?= $row['RequsetID'] ?>">
                                    <select name="status" class="form-select" style="margin-bottom: 5px;">
                                        <option value="قيد التنفيذ" <?= $row['Status'] == 'قيد التنفيذ' ? 'selected' : '' ?>>قيد التنفيذ</option>
                                        <option value="تم الإصلاح" <?= $row['Status'] == 'تم الإصلاح' ? 'selected' : '' ?>>تم الإصلاح</option>
                                        <option value="تم الإلغاء" <?= $row['Status'] == 'تم الإلغاء' ? 'selected' : '' ?>>تم الإلغاء</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary btn-sm w-100">
                                        <i class="fas fa-save"></i> حفظ
                                    </button>
                                </form>
                            </td>
                            <td>
                                <button onclick="confirmDelete(<?= $row['RequsetID'] ?>)" 
                                        class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i> حذف
                                </button>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="no-requests">
                <i class="fas fa-info-circle fa-2x mb-3"></i>
                <p>لا توجد طلبات لعرضها</p>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function confirmDelete(requestId) {
            if (confirm("هل أنت متأكد أنك تريد حذف هذا الطلب؟")) {
                window.location.href = "delete_request.php?id=" + requestId;
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>