<?php
// รวมไฟล์เชื่อมต่อฐานข้อมูล
include('db_connection.php'); // ไฟล์เชื่อมต่อฐานข้อมูล MySQLi

// CheckUserLogin_Fornt();

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Query ดึงข้อมูลจาก tbl_product
    $query = "SELECT * FROM tbl_product WHERE id = ?";
    // $query = "SELECT barcode, batch_no, genaric_name, brand_name, category FROM tbl_product WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id); // "i" หมายถึง integer
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc(); // ดึงข้อมูลเป็น associative array
        echo json_encode($product);
    } else {
        echo json_encode(null);
    }

    $stmt->close();
}
?>
