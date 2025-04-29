<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['Role'] == 0) {
    $requestID = (int)$_POST['request_id'];
    $status = $conn->real_escape_string($_POST['status']);
    
    $dateResolved = ($status == 'تم الإصلاح') ? ", DateResolved = CURDATE()" : 
                   (($status == 'تم الإلغاء') ? ", DateResolved = NULL" : "");
    
    $sql = "UPDATE maintenance_requset 
            SET Status = '$status' $dateResolved
            WHERE RequsetID = $requestID";
    
    if ($conn->query($sql)) {
        header("Location: upkeep.php?updated=1");
    } else {
        header("Location: upkeep.php?updated=0");
    }
} else {
    header("Location: login.php");
}
$conn->close();
exit();
?>