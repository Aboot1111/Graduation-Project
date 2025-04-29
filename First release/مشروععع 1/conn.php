<?php
    $conn = new mysqli("localhost", "root", "", "college_maintenance_fixed");
    if ($conn->connect_error) {
        die("فشل الاتصال: " . $conn->connect_error);

    }
    
?>