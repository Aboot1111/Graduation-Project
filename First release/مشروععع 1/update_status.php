<?php
session_start();
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $request_id = $_POST['request_id'];
    $status = $_POST['status'];

    // لو تم الإصلاح، نحط التاريخ الحالي، غير كذا نخليه فاضي
    $dateResolved = ($status == 'تم الإصلاح') ? date('Y-m-d') : null;

    $stmt = $conn->prepare("UPDATE maintenance_requset SET Status=?, DateResolved=? WHERE RequsetID=?");
    $stmt->bind_param("ssi", $status, $dateResolved, $request_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    // ✅ نرجع المستخدم لصفحة upkeep
    header("Location: upkeep.php");
    exit();
}
?>
