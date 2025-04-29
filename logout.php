<?php
session_start();
session_unset();
session_destroy();
header("Location: login.php"); // غيّر اسم الصفحة إذا كانت غير login.php
exit();