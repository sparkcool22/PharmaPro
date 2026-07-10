<?php
include '../include/config.php';
include '../include/common.php';
include '../include/setting.php';

header('Content-Type: application/json');

$oDB = new DBI();
$start = $_POST['start'] ?? '';
$end = $_POST['end'] ?? '';

if (!$start || !$end) {
    echo json_encode(['data' => []]);
    exit;
}

$sql = "
    SELECT 
        s.sale_id,
        DATE(s.insert_date) AS sale_date,
        TIME(s.insert_date) AS sale_time,
        p.brand_name,
        p.saleaccount_11,
        p.batch_no,
        s.payment,
        i.quantity,
        i.price,
        i.discount,
        i.total_price
    FROM tbl_sales s
    INNER JOIN tbl_sale_items i ON s.sale_id = i.sale_id
    INNER JOIN tbl_product p ON i.product_id = p.id
    WHERE s.insert_date BETWEEN '{$start} 00:00:00' AND '{$end} 23:59:59'
      AND s.approve_status = 'A'
      AND i.approve_status = 'A'
    ORDER BY s.insert_date ASC
";

$result = $oDB->Query($sql);

$data = [];
$no = 1;
while ($row = $result->FetchRow(DBI_ASSOC)) {
        // แปลง payment
        $paymentType = '';
        if ($row['payment'] === 'C') {
            $paymentType = 'เงินสด';
        } elseif ($row['payment'] === 'T') {
            $paymentType = 'เงินโอน';
        } else {
            $paymentType = 'อื่นๆ';
        }
        // แปลง ขย11
        $sale11Type = '';
        if ($row['saleaccount_11'] === 'Y') {
            $sale11Type = 'Yes';
        } elseif ($row['saleaccount_11'] === 'N') {
            $sale11Type = 'No';
        } else {
            $sale11Type = 'อื่นๆ';
        }
    $data[] = [
        'no' => $no++,
        'sale_date' => $row['sale_date'],
        'sale_time' => $row['sale_time'],
        'sale_id' => $row['sale_id'],
        'brand_name' => $row['brand_name'],
        'saleaccount_11' => $sale11Type,
        'batch_no' => $row['batch_no'],
        'payment' => $paymentType,
        'quantity' => (int)$row['quantity'],
        'price' => (float)$row['price'],
        'discount' => (float)$row['discount'],
        'total_price' => (float)$row['total_price']
    ];
}

echo json_encode(['data' => $data]);

?>