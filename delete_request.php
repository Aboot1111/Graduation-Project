<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['Role']) || $_SESSION['Role'] != 0) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $requestID = (int)$_GET['id'];
    
    $stmt = $conn->prepare("SELECT Deviceimage FROM maintenance_requset WHERE RequsetID = ?");
    $stmt->bind_param("i", $requestID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if (!empty($row['Deviceimage']) && file_exists($row['Deviceimage'])) {
        unlink($row['Deviceimage']);
    }
    
    $stmt = $conn->prepare("DELETE FROM maintenance_requset WHERE RequsetID = ?");
    $stmt->bind_param("i", $requestID);
    
    if ($stmt->execute()) {
        header("Location: upkeep.php?deleted=1");
    } else {
        header("Location: upkeep.php?deleted=0&error=" . urlencode($stmt->error));
    }
    $stmt->close();
} else {
    header("Location: upkeep.php");
}
$conn->close();
exit();
?>