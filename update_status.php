<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['Role']) || $_SESSION['Role'] != 0) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestID = (int)$_POST['request_id'];
    $status = $conn->real_escape_string($_POST['status']);
    
    $sql = "UPDATE maintenance_requset SET Status = ? WHERE RequsetID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $requestID);
    
    if ($stmt->execute()) {
        header("Location: upkeep.php?updated=1");
    } else {
        header("Location: upkeep.php?updated=0");
    }
    $stmt->close();
} else {
    header("Location: upkeep.php");
}
$conn->close();
?>