<?php
include '../include/config.php';
include '../include/common.php';
include '../include/setting.php';

CheckUserLogin_Fornt();

$oDB = new DBI();

$draw   = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
$start  = isset($_POST['start']) ? intval($_POST['start']) : 0;
$length = isset($_POST['length']) ? intval($_POST['length']) : 25;

$searchValue = '';
if (isset($_POST['search']['value'])) {
    $searchValue = trim($_POST['search']['value']);
}

$columns = [
    0 => 's.id',
    1 => 's.sale_id',
    2 => 'items',
    3 => 's.insert_date',
    4 => 's.insert_date',
    5 => 's.payment',
    6 => 's.total_amount',
    7 => 'c.customer_name'
];

$orderColumnIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 0;

if (isset($_POST['order'][0]['dir'])) {
    $orderDir = strtolower($_POST['order'][0]['dir']) === 'asc' ? 'ASC' : 'DESC';
} else {
    $orderDir = 'DESC';
}

$orderColumn = isset($columns[$orderColumnIndex]) ? $columns[$orderColumnIndex] : 's.id';

$where = " WHERE s.approve_status = 'A' ";

if ($searchValue !== '') {
    $safeSearch = addslashes($searchValue);
    $where .= " AND (
        s.sale_id LIKE '%{$safeSearch}%'
        OR c.customer_name LIKE '%{$safeSearch}%'
        OR s.total_amount LIKE '%{$safeSearch}%'
    ) ";
}

/* จำนวนทั้งหมด */
$totalRecords = $oDB->QueryOne("
    SELECT COUNT(*)
    FROM tbl_sales s
    WHERE s.approve_status = 'A'
");

/* จำนวนหลัง search */
$totalFiltered = $oDB->QueryOne("
    SELECT COUNT(*)
    FROM tbl_sales s
    LEFT JOIN tbl_customer c ON c.id = s.customer_id
    {$where}
");

/* ดึงเฉพาะหน้าปัจจุบัน */
$sql = "
    SELECT
        s.id,
        s.sale_id,
        s.insert_date,
        s.payment,
        s.total_amount,
        s.customer_id,
        s.approve_status,
        IFNULL(si.items, 0) AS items,
        IFNULL(c.customer_name, '') AS customer
    FROM tbl_sales s
    LEFT JOIN tbl_customer c
        ON c.id = s.customer_id
    LEFT JOIN (
        SELECT sale_id, COUNT(*) AS items
        FROM tbl_sale_items
        WHERE approve_status = 'A'
        GROUP BY sale_id
    ) si
        ON si.sale_id = s.sale_id
    {$where}
    ORDER BY {$orderColumn} {$orderDir}
    LIMIT {$start}, {$length}
";

$rs = $oDB->Query($sql);

$data = [];
$no = $start + 1;

while ($row = $rs->FetchRow(DBI_ASSOC)) {

    $dt = new DateTime($row['insert_date']);
    $curDate = $dt->format('d-m-Y');
    $curTime = $dt->format('H:i:s');

    $paymentText = ($row['payment'] == 'C') ? 'เงินสด' : 'โอนเงิน';

    $statusHtml = '
        <a href="?act=inactive&status=N&id=' . $row['id'] . '">
            <span class="badge badge-pill badge-success">
                <i class="fas fa-check-circle"></i> Active
            </span>
        </a>
    ';

    $toolsHtml = '
        <a class="btn btn-warning btn-xs" href="order.php?act=edit&saleid=' . $row['sale_id'] . '">
            <i class="fas fa-pencil-alt"></i> Edit
        </a>
    ';

    $data[] = [
        'no'           => $no,
        'sale_id'      => $row['sale_id'],
        'items'        => $row['items'],
        'cur_date'     => $curDate,
        'cur_time'     => $curTime,
        'payment_text' => $paymentText,
        'total_amount' => number_format($row['total_amount'], 2),
        'customer'     => $row['customer'],
        'status_html'  => $statusHtml,
        'tools_html'   => $toolsHtml
    ];

    $no++;
}

header('Content-Type: application/json; charset=utf-8');

echo json_encode([
    'draw'            => $draw,
    'recordsTotal'    => intval($totalRecords),
    'recordsFiltered' => intval($totalFiltered),
    'data'            => $data
]);