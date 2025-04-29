<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include 'conn.php';
$ms = "";

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
            $_SESSION['image'] = $user['image'];
            
            header("Location: " . ($user['Role'] == 0 ? "admin_home.php" : "user_home.php"));
            exit();
        } else {
            $ms = "كلمة المرور غير صحيحة!";
        }
    } else {
        $ms = "البريد الإلكتروني غير مسجل!";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/login.css">
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
<body class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="card">
        <h5 class="card-title text-center p-3"><i class="fas fa-sign-in-alt"></i> تسجيل الدخول</h5>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3 input-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="email" class="form-control" name="email" placeholder="البريد الإلكتروني" required>
                </div>
                <div class="mb-3 input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" class="form-control" name="password" placeholder="كلمة المرور" required>
                </div>
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-sign-in-alt"></i> دخول</button>
                
                <?php if (!empty($ms)): ?>
                <div class="alert alert-danger mt-3 text-center"><?= $ms ?></div>
                <?php endif; ?>
            </form>
            
            <div class="text-center mt-4">
                <p>ليس لديك حساب؟ <a href="signup.php" class="btn btn-outline-secondary btn-sm">إنشاء حساب جديد</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>