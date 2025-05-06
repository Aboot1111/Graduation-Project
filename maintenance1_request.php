<?php
session_start();
include 'conn.php';
include 'header.php';

if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deviceType = $conn->real_escape_string($_POST['device-type']);
    $description = $conn->real_escape_string($_POST['issue-details']);
    $deviceLocation = $conn->real_escape_string($_POST['device-location']);
    $status = 'قيد التنفيذ';
    $dateCreated = date('Y-m-d');
    $UserID = $_SESSION['UserID'];
    $deviceImage = null;

    // معالجة رفع الصورة
    if (isset($_FILES['device-image']) && $_FILES['device-image']['error'] == 0) {
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = strtolower(pathinfo($_FILES['device-image']['name'], PATHINFO_EXTENSION));
        
        if (in_array($file_extension, $allowed_extensions)) {
            $upload_dir = __DIR__ . '/uploads/devices/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            $new_filename = 'device_' . uniqid() . '.' . $file_extension;
            $target_path = $upload_dir . $new_filename;
            
            if (move_uploaded_file($_FILES['device-image']['tmp_name'], $target_path)) {
                $deviceImage = 'uploads/devices/' . $new_filename;
            } else {
                $error = "فشل في رفع الصورة";
            }
        } else {
            $error = "نوع الملف غير مسموح به. يرجى رفع صورة بصيغة JPG, JPEG, PNG أو GIF";
        }
    }

    if (empty($error)) {
        $conn->begin_transaction();
        try {
            // إضافة الجهاز
            $stmtDevice = $conn->prepare("INSERT INTO device (DeviceType) VALUES (?)");
            $stmtDevice->bind_param("s", $deviceType);
            $stmtDevice->execute();
            $deviceID = $stmtDevice->insert_id;

            // إضافة طلب الصيانة
            $stmtRequest = $conn->prepare("INSERT INTO maintenance_requset 
                                        (UserID, DeviceID, Description, DeviceLocation, Status, DateCreated, Deviceimage) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmtRequest->bind_param("iisssss", $UserID, $deviceID, $description, $deviceLocation, $status, $dateCreated, $deviceImage);
            $stmtRequest->execute();

            $conn->commit();
            $success = "تم إرسال طلب الصيانة بنجاح!";
            header("Refresh: 2; url=upkeep.php");
        } catch (Exception $e) {
            $conn->rollback();
            $error = "حدث خطأ أثناء إرسال الطلب: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلب صيانة أجهزة الكلية</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            min-height: 100vh;
        }
        .container {
            max-width: 700px;
            margin: 30px auto;
            padding: 25px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        .form-label {
            font-weight: bold;
            margin-bottom: 8px;
        }
        .btn-submit {
            background: linear-gradient(45deg, #4CAF50, #2E7D32);
            border: none;
            transition: all 0.3s;
        }
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        .alert {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4"><i class="fas fa-tools"></i> طلب صيانة أجهزة الكلية</h1>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php elseif (!empty($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="device-type" class="form-label">نوع الجهاز:</label>
                <select id="device-type" name="device-type" class="form-select" required>
                    <option value="لابتوب">لابتوب</option>
                    <option value="جهاز كمبيوتر">جهاز كمبيوتر</option>
                    <option value="ماوس">ماوس</option>
                    <option value="كيبورد">كيبورد</option>
                    <option value="شاشة">شاشة</option>
                    <option value="بروجكتر">بروجكتر</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="device-location" class="form-label">موقع الجهاز:</label>
                <input type="text" id="device-location" name="device-location" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label for="issue-details" class="form-label">تفاصيل المشكلة:</label>
                <textarea id="issue-details" name="issue-details" class="form-control" rows="5" required></textarea>
            </div>
            
            <div class="mb-4">
                <label for="device-image" class="form-label">صورة الجهاز (اختياري):</label>
                <input type="file" id="device-image" name="device-image" class="form-control" accept="image/*">
                <small class="text-muted">الصيغ المسموحة: JPG, JPEG, PNG, GIF</small>
            </div>
            
            <button type="submit" class="btn btn-submit btn-lg w-100 py-2">
                <i class="fas fa-paper-plane"></i> إرسال الطلب
            </button>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>