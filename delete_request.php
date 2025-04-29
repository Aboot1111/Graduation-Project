<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include 'conn.php';

if (!isset($_SESSION['Role']) || $_SESSION['Role'] != 0) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $requestID = (int)$_GET['id'];
    
    $stmt = $conn->prepare("DELETE FROM maintenance_requset WHERE RequsetID = ?");
    $stmt->bind_param("i", $requestID);
    
    if ($stmt->execute()) {
        header("Location: upkeep.php?deleted=1");
    } else {
        header("Location: upkeep.php?deleted=0");
    }
    $stmt->close();
} else {
    header("Location: upkeep.php");
}
$conn->close();
exit();
?>