<?php
// ข้อมูลการเชื่อมต่อฐานข้อมูล
include('db_connection.php'); // ไฟล์เชื่อมต่อฐานข้อมูล MySQLi

CheckUserLogin_Fornt();

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['orders'])) {
    $orders = $_POST['orders'];

    // เตรียมคำสั่ง SQL สำหรับการเพิ่มข้อมูล
    $stmt = $conn->prepare("INSERT INTO spark (product_name, quantity, unit_price, discount, total) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sdddd", $product_name, $quantity, $unit_price, $discount, $total);

    foreach ($orders as $order) {
        $product_name = $order['product_name'];
        $quantity = $order['quantity'];
        $unit_price = $order['unit_price'];
        $discount = $order['discount'];
        $total = $order['total'];

        $stmt->execute();
    }

    echo "ข้อมูลถูกบันทึกเรียบร้อยแล้ว!";
    $stmt->close();
}

$conn->close();
?>