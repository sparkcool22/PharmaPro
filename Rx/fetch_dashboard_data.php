<?php
include '../include/config.php';
include '../include/common.php';
include '../include/setting.php';

$start = isset($_POST['start']) ? $_POST['start'] : '';
$end = isset($_POST['end']) ? $_POST['end'] : '';

$total_amount = 0;
$total_items = 0;
$total_quantity = 0;
$cash_amount = 0;
$transfer_amount = 0;

if ($start && $end) {
    $oDB = new DBI();

    // ยอดรวมจำนวนเงิน
    $rowAmount = $oDB->QueryRow("
        SELECT SUM(total_amount) AS total
        FROM tbl_sales
        WHERE DATE(insert_date) BETWEEN '$start' AND '$end'
    ", DBI_ASSOC);
    $total_amount = $rowAmount['total'] ?? 0;

    // จำนวนรายการสินค้า (นับจำนวนรายการ)
    $rowItems = $oDB->QueryRow("
        SELECT COUNT(s_items.id) AS total_items
        FROM tbl_sales s
        INNER JOIN tbl_sale_items s_items ON s.sale_id = s_items.sale_id
        WHERE DATE(s.insert_date) BETWEEN '$start' AND '$end'
        AND s.approve_status = 'A'
        AND s_items.approve_status = 'A'

    ", DBI_ASSOC);
    $total_items = $rowItems['total_items'] ?? 0;

    // จำนวนสินค้า (นับ sum quantity)
    $rowQuantity = $oDB->QueryRow("
        SELECT SUM(s_items.quantity) AS total_quantity
        FROM tbl_sales s
        INNER JOIN tbl_sale_items s_items ON s.sale_id = s_items.sale_id
        WHERE DATE(s.insert_date) BETWEEN '$start' AND '$end'
        AND s.approve_status = 'A'
        AND s_items.approve_status = 'A'
    ", DBI_ASSOC);
    $total_quantity = $rowQuantity['total_quantity'] ?? 0;

    // ยอดเงินสด
    $rowCash = $oDB->QueryRow("
        SELECT SUM(total_amount) AS cash_amount
        FROM tbl_sales
        WHERE payment = 'C' AND DATE(insert_date) BETWEEN '$start' AND '$end'
        AND approve_status = 'A'
    ", DBI_ASSOC);
    $cash_amount = $rowCash['cash_amount'] ?? 0;

    // ยอดเงินโอน
    $rowTransfer = $oDB->QueryRow("
        SELECT SUM(total_amount) AS transfer_amount
        FROM tbl_sales
        WHERE payment = 'T' AND DATE(insert_date) BETWEEN '$start' AND '$end'
        AND approve_status = 'A'
    ", DBI_ASSOC);
    $transfer_amount = $rowTransfer['transfer_amount'] ?? 0;

    // จำนวนคน
    $rowBuyer = $oDB->QueryRow("
        SELECT COUNT(DISTINCT sale_id) AS buyer_amount
        FROM tbl_sales        
        WHERE  DATE(insert_date) BETWEEN '$start' AND '$end'
        AND approve_status = 'A'
    ", DBI_ASSOC);
    $buyer_amount = $rowBuyer['buyer_amount'] ?? 0;

}

// เพิ่ม Debug
header('Content-Type: application/json');
echo json_encode([
    'total_amount' => (float) $total_amount,
    'total_items' => (int) $total_items,
    'total_quantity' => (int) $total_quantity,
    'cash_amount' => (float) $cash_amount,
    'transfer_amount' => (float) $transfer_amount,
    'buyer_amount' => (float) $buyer_amount
]);

?>