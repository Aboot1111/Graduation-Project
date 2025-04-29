<?php
session_start();
$ms1 = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "conn.php";

    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $confirmPass = $_POST['confirmPassword'];

    // التحقق من البريد هل موجود مسبقاً
    $sql1 = "SELECT * FROM user WHERE Email='$email'";
    $query1 = $conn->query($sql1);
    if ($query1->num_rows > 0) {
        $ms1 = "الإيميل مسجّل مسبقًا!";
    } elseif ($pass !== $confirmPass) {
        $ms1 = "كلمة المرور وتأكيدها غير متطابقين!";
    } else {
        // تشفير كلمة المرور
        $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

        // إدخال البيانات
        $sql = "INSERT INTO user (Name, Email, Password, Role) VALUES ('$name', '$email', '$hashedPass', 1)";
        $query = $conn->query($sql);

        if ($query) {
            // تسجيل دخول مباشر بعد نجاح الإنشاء
            $_SESSION['Name'] = $name;
            $_SESSION['Email'] = $email;
            $_SESSION['Role'] = 1;

            $conn->close();
            header("Location: user_home.php"); // يدخل المستخدم على صفحة الطلب
            exit();
        } else {
            $ms1 = "خطأ أثناء التسجيل: " . $conn->error;
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>إنشاء حساب</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="project.css/signup.css">
</head>
<body>

  <div class="card">
    <h5 class="card-title"><i class="fas fa-user-plus"></i> إنشاء الحساب</h5>
    <form method="POST">
      <div class="form-group">
        <label for="name"><i class="fas fa-user"></i> اسم المتدرب أو المدرب رباعي</label>
        <input type="text" class="form-control" name="name" id="name" required>
      </div>

      <div class="form-group">
        <label for="email"><i class="fas fa-envelope"></i> إيميلك الشخصي</label>
        <input type="email" class="form-control" name="email" id="email" required>
      </div>

      <div class="form-group">
        <label for="password"><i class="fas fa-lock"></i> كلمة المرور</label>
        <input type="password" class="form-control" name="password" id="password" required>
      </div>

      <div class="form-group">
        <label for="confirmPassword"><i class="fas fa-lock"></i> تأكيد كلمة المرور</label>
        <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" required>
      </div>

      <button type="submit" class="btn btn-primary w-100 mt-3"><i class="fas fa-user-check"></i> إنشاء الحساب</button>

      <?php if (!empty($ms1)): ?>
        <div class="alert alert-info mt-3"><?php echo $ms1; ?></div>
      <?php endif; ?>
    </form>

    <!-- زر الانتقال لتسجيل الدخول -->
    <div class="text-center mt-4">
      <p>هل لديك حساب؟ <a href="login.php" class="btn btn-outline-secondary btn-sm">تسجيل الدخول</a></p>
    </div>
  </div>

</body>
</html>
