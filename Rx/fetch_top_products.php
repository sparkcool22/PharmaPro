<?php
include '../include/config.php';
include '../include/common.php';
include '../include/setting.php';

header('Content-Type: application/json');

$oDB = new DBI();
$start = isset($_POST['start']) ? $_POST['start'] : '';
$end = isset($_POST['end']) ? $_POST['end'] : '';

if (!$start || !$end) {
    echo json_encode([]);
    exit;
}

$sql = "
    SELECT p.brand_name, SUM(si.quantity) AS total_quantity
    FROM tbl_sale_items si
    INNER JOIN tbl_sales s ON si.sale_id = s.sale_id
    INNER JOIN tbl_product p ON si.product_id = p.id
    WHERE s.insert_date BETWEEN '$start 00:00:00' AND '$end 23:59:59'
      AND si.approve_status = 'A'
    GROUP BY p.brand_name
    ORDER BY total_quantity DESC
    LIMIT 5
";

$result = $oDB->Query($sql);

$data = [];
while ($row = $result->FetchRow(DBI_ASSOC)) {
    $productName = $row['brand_name'];
    if (mb_strlen($productName) > 30) {
        $productName = mb_substr($productName, 0, 30) . '...'; // ตัดชื่อถ้ายาวเกิน
    }
    $data[] = [
        'name' => $productName,
        'quantity' => (int)$row['total_quantity']
    ];
}

echo json_encode($data);
?>