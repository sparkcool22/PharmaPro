<?php
// รวมไฟล์เชื่อมต่อฐานข้อมูล
include('db_connection.php'); // ไฟล์เชื่อมต่อฐานข้อมูล MySQLi

// CheckUserLogin_Fornt();

header('Content-Type: application/json');

// ดึงยอดรวมของวันนี้ทั้งหมด
$queryTotal = "SELECT SUM(total_amount) as total_amount FROM tbl_sales WHERE DATE(insert_date) = CURDATE()";
$resultTotal = $conn->query($queryTotal);
$rowTotal = $resultTotal->fetch_assoc();
$totalAmount = $rowTotal['total_amount'] ?? 0;

// ดึงยอดรวมเฉพาะที่ payment = 'C' ของวันนี้
$queryCash = "SELECT SUM(total_amount) as cash_total FROM tbl_sales WHERE DATE(insert_date) = CURDATE() AND payment = 'C'";
$resultCash = $conn->query($queryCash);
$rowCash = $resultCash->fetch_assoc();
$cashTotal = $rowCash['cash_total'] ?? 0;

// ดึงยอดรวมเฉพาะที่ payment = 'T' ของวันนี้
$queryTransfer = "SELECT SUM(total_amount) as transfer_total FROM tbl_sales WHERE DATE(insert_date) = CURDATE() AND payment = 'T'";
$resultTransfer = $conn->query($queryTransfer);
$rowTransfer = $resultTransfer->fetch_assoc();
$transferTotal = $rowTransfer['transfer_total'] ?? 0;

// ดึงยอดรวม quantity ของวันนี้
$queryQuantity = "
    SELECT SUM(tbl_sale_items.quantity) as total_quantity
    FROM tbl_sale_items
    INNER JOIN tbl_sales ON tbl_sale_items.sale_id = tbl_sales.sale_id
    WHERE DATE(tbl_sales.insert_date) = CURDATE() AND tbl_sale_items.approve_status = 'A'
";
$resultQuantity = $conn->query($queryQuantity);
$rowQuantity = $resultQuantity->fetch_assoc();
$totalQuantity = $rowQuantity['total_quantity'] ?? 0;

// ดึงยอดรวม รายการ ของวันนี้
$queryRowCount = "
    SELECT COUNT(*) as row_count
    FROM tbl_sale_items
    INNER JOIN tbl_sales ON tbl_sale_items.sale_id = tbl_sales.sale_id
    WHERE DATE(tbl_sales.insert_date) = CURDATE() AND tbl_sale_items.approve_status = 'A'
";
$resultRowCount = $conn->query($queryRowCount);
$rowRowCount = $resultRowCount->fetch_assoc();
$rowCount = $rowRowCount['row_count'] ?? 0;

$queryProfit = "
    SELECT
        SUM(si.total_price) AS total_sales,
        SUM(p.price_per_unit * si.quantity) AS total_cost,
        SUM(si.total_price - (p.price_per_unit * si.quantity)) AS total_profit
    FROM tbl_sale_items si
    INNER JOIN tbl_sales s ON s.sale_id = si.sale_id
    INNER JOIN tbl_product p ON p.id = si.product_id
    WHERE DATE(s.insert_date) = CURDATE()
      AND si.approve_status = 'A'
";
$resultProfit = $conn->query($queryProfit);
$rowProfit = $resultProfit->fetch_assoc();

$totalCost = $rowProfit['total_cost'] ?? 0;
$totalProfit = $rowProfit['total_profit'] ?? 0;

echo json_encode([
    'success' => true,
    'total_amount' => $totalAmount,
    'cash_total' => $cashTotal,
    'transfer_total' => $transferTotal,
    'total_quantity' => $totalQuantity,
    'row_count' => $rowCount,
    'total_cost' => $totalCost,
    'total_profit' => $totalProfit
    ]);

?>