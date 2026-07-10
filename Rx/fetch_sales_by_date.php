<?php
include '../include/config.php';
include '../include/common.php';
include '../include/setting.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

$oDB = new DBI();

$start = isset($_POST['start']) ? $_POST['start'] : '';
$end = isset($_POST['end']) ? $_POST['end'] : '';

if (!$start || !$end) {
    echo json_encode(['error' => true, 'message' => 'No start or end date']);
    exit;
}

$sql = "
    SELECT DATE(insert_date) AS sale_date, SUM(total_amount) AS total
    FROM tbl_sales
    WHERE DATE(insert_date) BETWEEN '$start' AND '$end'
    AND approve_status = 'A'
    GROUP BY DATE(insert_date)
    ORDER BY sale_date
";

$result = $oDB->Query($sql);
if (!$result) {
    echo json_encode(['error' => true, 'message' => 'Query Failed: ' . $oDB->error]);
    exit;
}

$data = [];
while ($row = $result->FetchRow(DBI_ASSOC)) {
    $data[] = [
        'date' => $row['sale_date'],
        'total' => (float) $row['total']
    ];
}

header('Content-Type: application/json');
echo json_encode($data);
?>