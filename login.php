<?php
session_start();
include 'conn.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE Email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['Password'])) {
            $_SESSION['UserID'] = $user['UserID'];
            $_SESSION['FirstName'] = $user['FirstName'];
            $_SESSION['LastName'] = $user['LastName'];
            $_SESSION['Email'] = $user['Email'];
            $_SESSION['Role'] = $user['Role'];
            
            header("Location: " . ($user['Role'] == 0 ? "admin_home.php" : "user_home.php"));
            exit();
        } else {
            $error = "كلمة المرور غير صحيحة!";
        }
    } else {
        $error = "البريد الإلكتروني غير مسجل!";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
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
        .input-icon {
            position: relative;
        }
        .input-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
        }
        .input-icon input {
            padding-right: 15px;
            padding-left: 40px;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center">
    <div class="card col-md-5 mx-3">
        <div class="card-header bg-primary text-white text-center py-3">
            <h5><i class="fas fa-sign-in-alt"></i> تسجيل الدخول</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger text-center"><?= $error ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="mb-3 input-icon">
                    <i class="fas fa-envelope text-primary"></i>
                    <input type="email" class="form-control" name="email" placeholder="البريد الإلكتروني" required>
                </div>
                
                <div class="mb-3 input-icon">
                    <i class="fas fa-lock text-primary"></i>
                    <input type="password" class="form-control" name="password" placeholder="كلمة المرور" required>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 py-2">
                    <i class="fas fa-sign-in-alt"></i> دخول
                </button>
            </form>
            
            <div class="text-center mt-4">
                <p>ليس لديك حساب؟ <a href="signup.php" class="btn btn-outline-secondary btn-sm">إنشاء حساب جديد</a></p>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>