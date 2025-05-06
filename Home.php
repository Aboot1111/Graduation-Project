<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام صيانة أجهزة الكلية التقنية</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1e3c72;
            --secondary-color: #2a5298;
            --accent-color: #ffc107;
        }
        body {
            font-family: 'Tajawal', sans-serif;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .hero-section {
            padding: 80px 0;
            background: rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('background-pattern.png') repeat;
            opacity: 0.1;
            z-index: -1;
        }
        .college-logo {
            width: 150px;
            height: 150px;
            object-fit: contain;
            margin-bottom: 20px;
        }
        .main-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--accent-color);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .sub-title {
            font-size: 1.2rem;
            margin-bottom: 40px;
            max-width: 700px;
        }
        .btn-main {
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 50px;
            background-color: var(--accent-color);
            color: #000;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .btn-main:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 20px rgba(0, 0, 0, 0.3);
            background-color: #ffca28;
        }
        .features-section {
            padding: 60px 0;
            background: rgba(255, 255, 255, 0.1);
        }
        .feature-box {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            transition: all 0.3s;
            height: 100%;
        }
        .feature-box:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.2);
        }
        .feature-icon {
            font-size: 2.5rem;
            color: var(--accent-color);
            margin-bottom: 20px;
        }
        footer {
            background: rgba(0, 0, 0, 0.7);
            padding: 20px 0;
            margin-top: auto;
        }
        @media (max-width: 768px) {
            .main-title {
                font-size: 2rem;
            }
            .college-logo {
                width: 120px;
                height: 120px;
            }
        }
    </style>
</head>
<body>
    
    <section class="hero-section text-center d-flex align-items-center">
        <div class="container">
            <img src="images/logo.jpg" alt="شعار الكلية التقنية" class="college-logo">
            <h1 class="main-title">نظام إدارة طلبات الصيانة</h1>
            <p class="sub-title mx-auto">
                نظام متكامل لإدارة طلبات صيانة أجهزة الكلية التقنية، يمكنك من تسجيل الطلبات ومتابعتها بكل سهولة
            </p>
            <div class="d-flex justify-content-center gap-4">
                <a href="login.php" class="btn btn-main">
                    <i class="fas fa-sign-in-alt"></i> تسجيل الدخول
                </a>
                <a href="signup.php" class="btn btn-main">
                    <i class="fas fa-user-plus"></i> إنشاء حساب
                </a>
            </div>
        </div>
    </section>

    <!-- قسم المميزات -->
    <section class="features-section">
        <div class="container">
            <h2 class="text-center mb-5" style="color: var(--accent-color);">مميزات النظام</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-tools"></i>
                        </div>
                        <h3>إدارة الطلبات</h3>
                        <p>تقديم طلبات الصيانة ومتابعتها بكل سهولة ويسر</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <h3>التنبيهات</h3>
                        <p>تعديل وابلاغ فوري عند تعديل حالة الطلب</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3>تقارير إحصائية</h3>
                        <p>تقارير دورية عن أداء الصيانة وأوقات الاستجابة</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

 
    <footer class="text-center">
        <div class="container">
            <p>جميع الحقوق محفوظة &copy; <?= date('Y') ?> الكلية التقنية</p>
            <p>المؤسسة العامة للتدريب التقني والمهني</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>