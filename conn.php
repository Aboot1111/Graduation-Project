<?php
$conn = new mysqli("localhost", "root", "", "college_maintenance_fixed");

if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

mysqli_set_charset($conn, "utf8");


if (!file_exists('uploads/devices')) {
    mkdir('uploads/devices', 0777, true);
}
?>