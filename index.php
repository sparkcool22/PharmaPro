<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PharmaPro: RoongRuang Pharmacy</title>

</head>

<body>
<?php
// เริ่มต้นเซสชัน (ถ้าจำเป็น)
session_start();

// ตรวจสอบเงื่อนไข (ถ้ามี)
// ตัวอย่าง: เช็คการล็อกอิน หรือสถานะบางอย่าง
if (!isset($_SESSION['user_logged_in'])) {
    // Redirect ไปยัง index.php
    header("Location: Rx/index.php");
    exit(); // หยุดการทำงานของไฟล์เพื่อป้องกันโค้ดด้านล่างทำงานต่อ
}

// โค้ดอื่น ๆ (ถ้ามี)
?>
</body>

</html>