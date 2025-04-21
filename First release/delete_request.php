<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['Role']) || $_SESSION['Role'] != 0) {
    // فقط المدير يقدر يحذف
    header("Location: upkeep.php");
    exit();
}

if (isset($_GET['id'])) {
    $requestID = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM maintenance_requset WHERE RequsetID = ?");
    $stmt->bind_param("i", $requestID);

    if ($stmt->execute()) {
        // حذف ناجح
        $stmt->close();
        $conn->close();
        header("Location: upkeep.php?deleted=1");
        exit();
    } else {
        // فشل في الحذف
        $stmt->close();
        $conn->close();
        header("Location: upkeep.php?deleted=0");
        exit();
    }
} else {
    header("Location: upkeep.php");
    exit();
}
