<?php
session_start();
include 'conn.php';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $conn->real_escape_string($_POST['firstName']);
    $lastName = $conn->real_escape_string($_POST['lastName']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($password !== $confirmPassword) {
        $error = "كلمات المرور غير متطابقة!";
    } else {
        $check_email = $conn->query("SELECT * FROM user WHERE Email='$email'");
        
        if ($check_email->num_rows > 0) {
            $error = "البريد الإلكتروني مسجل مسبقاً!";
        } else {
            // تعيين الصورة الافتراضية للمستخدم العادي
            $image = 'images/default.png';
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO user (FirstName, LastName, Email, Password, Role, image) 
                    VALUES ('$firstName', '$lastName', '$email', '$hashed_password', 1, '$image')";
            
            if ($conn->query($sql)) {
                $_SESSION['UserID'] = $conn->insert_id;
                $_SESSION['FirstName'] = $firstName;
                $_SESSION['LastName'] = $lastName;
                $_SESSION['Email'] = $email;
                $_SESSION['Role'] = 1;
                $_SESSION['image'] = $image;
                
                header("Location: user_home.php");
                exit();
            } else {
                $error = "حدث خطأ أثناء التسجيل: " . $conn->error;
            }
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء حساب جديد</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            font-family: 'Tajawal', sans-serif;
            height: 100vh;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center">
    <div class="card col-md-5 mx-3">
        <div class="card-header bg-primary text-white text-center py-3">
            <h5><i class="fas fa-user-plus"></i> إنشاء حساب جديد</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger text-center"><?= $error ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="firstName" placeholder="الاسم الأول" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="lastName" placeholder="الاسم الأخير" required>
                    </div>
                </div>

                <div class="mb-3 mt-3">
                    <input type="email" class="form-control" name="email" placeholder="البريد الإلكتروني" required>
                </div>

                <div class="mb-3">
                    <input type="password" class="form-control" name="password" placeholder="كلمة المرور" required>
                </div>

                <div class="mb-3">
                    <input type="password" class="form-control" name="confirmPassword" placeholder="تأكيد كلمة المرور" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2">
                    <i class="fas fa-user-check"></i> إنشاء حساب
                </button>
            </form>

            <div class="text-center mt-4">
                <p>لديك حساب بالفعل؟ <a href="login.php" class="btn btn-outline-secondary btn-sm">تسجيل الدخول</a></p>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>