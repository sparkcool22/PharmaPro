<?php
// รวมไฟล์เชื่อมต่อฐานข้อมูล
include('db_connection.php'); // ไฟล์เชื่อมต่อฐานข้อมูล MySQLi

// CheckUserLogin_Fornt();

// กำหนดเขตเวลาให้ตรงกับที่ต้องการ
date_default_timezone_set("Asia/Bangkok");

// $query = "SELECT * FROM tbl_product WHERE quantity_in_stock > 0 AND approve_status = 'A' ORDER BY brand_name ASC, expiration_date DESC";
$query = "SELECT 
    p.*, 
    p.id AS product_id,
    s.* 
FROM 
    tbl_product p
LEFT JOIN 
    tbl_supplier s 
    ON p.supplier_id = s.id
WHERE 
    p.quantity_in_stock > 0 
    AND p.approve_status = 'A'
ORDER BY 
    p.brand_name ASC, 
    p.expiration_date DESC;
";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $rownum = 1;
    while ($row = $result->fetch_assoc()) {
        $expiration_date = DateTime::createFromFormat("Y-m-d", $row["expiration_date"])->format("d-m-Y");
        echo "<tr>
                <td>{$rownum}</td>
                <td class='product1-name'>" . htmlspecialchars($row['genaric_name']) . "</td>
                <td class='product-name'>" . htmlspecialchars($row['brand_name']) . "</td>
                <td>" . htmlspecialchars($row['batch_no']) . "</td>
                <td>" . htmlspecialchars($row['supplier_name']) . "</td>
                <td class='quantity-in-stock'>" . htmlspecialchars($row['quantity_in_stock']) . "</td>
                <td>" . htmlspecialchars($row['price_per_unit']) . "</td>
                <td class='retail-price'>" . htmlspecialchars($row['retail_price']) . "</td>
                <td class='member-price'>" . htmlspecialchars($row['member_price']) . "</td>
                <td>{$expiration_date}</td>
                <td><button class='btn btn-success btn-sm select-btn' data-id='" . htmlspecialchars($row['product_id']) . "'>เลือก</button></td>
              </tr>";
        $rownum++;
    }
} else {
    echo "<tr><td colspan='9'>ไม่มีสินค้า</td></tr>";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>