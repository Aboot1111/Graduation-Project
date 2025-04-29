<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include 'conn.php';
$ms1 = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $conn->real_escape_string($_POST['firstName']);
    $lastName = $conn->real_escape_string($_POST['lastName']);
    $email = $conn->real_escape_string($_POST['email']);
    $pass = $_POST['password'];
    $confirmPass = $_POST['confirmPassword'];

    $check = $conn->query("SELECT * FROM user WHERE Email='$email'");
    
    if ($check->num_rows > 0) {
        $ms1 = "الإيميل مسجّل مسبقًا!";
    } elseif ($pass !== $confirmPass) {
        $ms1 = "كلمة المرور غير متطابقة!";
    } else {
        $hashedPass = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user (FirstName, LastName, Email, Password, Role, image) 
                VALUES ('$firstName', '$lastName', '$email', '$hashedPass', 1, 'default.png')";

        if ($conn->query($sql)) {
            $_SESSION['UserID'] = $conn->insert_id;
            $_SESSION['FirstName'] = $firstName;
            $_SESSION['LastName'] = $lastName;
            $_SESSION['Email'] = $email;
            $_SESSION['Role'] = 1;
            $_SESSION['image'] = 'default.png';
            
            header("Location: user_home.php");
            exit();
        } else {
            $ms1 = "خطأ في التسجيل: " . $conn->error;
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
    <title>إنشاء حساب</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/signup.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            font-family: 'Tajawal', sans-serif;
        }
        .card {
            width: 100%;
            max-width: 500px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        .card-title {
            color: #1e3c72;
            font-weight: bold;
        }
        .btn-primary {
            background: linear-gradient(45deg, #1e3c72, #2a5298);
        }
        .profile-pic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #1e3c72;
            cursor: pointer;
        }
        #imageUpload {
            display: none;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="card">
        <h5 class="card-title text-center p-3"><i class="fas fa-user-plus"></i> إنشاء حساب جديد</h5>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="text-center mb-4">
                    <img id="profilePreview" src="images/default.png" class="profile-pic" onclick="document.getElementById('imageUpload').click()">
                    <input type="file" id="imageUpload" name="profileImage" accept="image/*">
                    <div class="mt-2">
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="document.getElementById('imageUpload').click()">
                            <i class="fas fa-camera"></i> اختر صورة شخصية
                        </button>
                    </div>
                </div>

                <div class="row g-2">
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

                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-user-check"></i> إنشاء حساب</button>

                <?php if (!empty($ms1)): ?>
                <div class="alert alert-danger mt-3 text-center"><?= $ms1 ?></div>
                <?php endif; ?>
            </form>

            <div class="text-center mt-4">
                <p>لديك حساب بالفعل؟ <a href="login.php" class="btn btn-outline-secondary btn-sm">تسجيل الدخول</a></p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('imageUpload').addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('profilePreview').src = event.target.result;
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>