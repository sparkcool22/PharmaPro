<?php
include '../include/config.php';
include '../include/common.php';
include '../include/setting.php';

header('Content-Type: application/json');

$oDB = new DBI();

$start = isset($_POST['start']) ? $_POST['start'] : '';
$end = isset($_POST['end']) ? $_POST['end'] : '';

if (!$start || !$end) {
    echo json_encode(['error' => true, 'message' => 'No start or end date']);
    exit;
}

// ดึงยอดขายรายชั่วโมง รวมตามช่วงวัน
$sql = "
    SELECT HOUR(insert_date) AS hour, SUM(total_amount) AS total
    FROM tbl_sales
    WHERE insert_date BETWEEN '$start 00:00:00' AND '$end 23:59:59'
      AND approve_status = 'A'
    GROUP BY HOUR(insert_date)
    ORDER BY hour ASC
";

$result = $oDB->Query($sql);

$data = [];
while ($row = $result->FetchRow(DBI_ASSOC)) {
    $data[] = [
        'hour' => str_pad($row['hour'], 2, '0', STR_PAD_LEFT) . ':00', // เช่น 01:00, 14:00
        'total' => (float)$row['total']
    ];
}

echo json_encode($data);
?>