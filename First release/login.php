<?php
session_start();
$ms = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'conn.php';

    $uname = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM user WHERE Email='$uname'";
    $query = $conn->query($sql);

    if ($query->num_rows == 1) {
        $user = $query->fetch_assoc();

        // التحقق من كلمة المرور
        if (password_verify($pass, $user['Password'])) {
            $_SESSION['Name'] = $user['Name'];
            $_SESSION['Email'] = $user['Email'];
            $_SESSION['Role'] = $user['Role'];
            $_SESSION['UserID'] = $user['UserID']; // ✅ هذا هو المفتاح

            // التوجيه حسب الدور
            if ($user['Role'] == 1) {
                header("Location: user_home.php");
            } elseif ($user['Role'] == 0) {
                header("Location: admin_home.php");
            }
            exit();
        } else {
            $ms = "كلمة المرور غير صحيحة!";
        }
    } else {
        $ms = "البريد الإلكتروني غير موجود!";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول - صيانة أجهزة الكلية</title>
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            text-align: center;
            background: url('login_background.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            color: white;
        }
        .container {
            margin-top: 100px;
            background: rgba(0, 0, 0, 0.7);
            padding: 40px;
            border-radius: 10px;
            display: inline-block;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.2);
        }
        .title {
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #ffcc00;
        }
        .form-group {
            margin: 15px 0;
        }
        input, button {
            padding: 12px;
            width: 100%;
            margin-top: 5px;
            border-radius: 5px;
            border: none;
            font-size: 16px;
        }
        button {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
            cursor: pointer;
        }
        .nav {
            margin-top: 20px;
        }
        .nav a {
            text-decoration: none;
            color: white;
            background: linear-gradient(45deg, #ff5722, #e64a19);
            padding: 10px 15px;
            border-radius: 8px;
        }
        .alert {
            background-color: #dc3545;
            color: white;
            padding: 10px;
            margin-top: 15px;
            border-radius: 5px;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="title">تسجيل الدخول</h1>
        <form method="post">
            <div class="form-group">
                <label for="username">البريد الإلكتروني:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">كلمة المرور:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" name="submit">تسجيل الدخول</button>

            <?php if (!empty($ms)): ?>
                <div class="alert"><?php echo $ms; ?></div>
            <?php endif; ?>
        </form>

        <div class="nav mt-4">
            <p>ليس لديك حساب؟ <a href="signup.php">إنشاء حساب جديد</a></p>
        </div>
    </div>
</body>
</html>
