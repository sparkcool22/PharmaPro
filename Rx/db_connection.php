<?php
$host = 'localhost';
$username = 'root';
$password = 'tedinno!!@@##';
$database = 'db_pharmapro';

// สร้างการเชื่อมต่อ
$conn = new mysqli($host, $username, $password, $database);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
