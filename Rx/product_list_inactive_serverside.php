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
    0  => 'p.id',
    1  => 'cu.full_name',
    2  => 'uu.full_name',
    3  => 'p.barcode',
    4  => 'p.genaric_name',
    5  => 'p.brand_name',
    6  => 'dc.cat_name',
    7  => 'p.batch_no',
    8  => 'p.medicine_label',
    9  => 'p.prescription_required',
    10 => 'p.saleaccount_11',
    11 => 'p.expiration_date',
    12 => 'p.min_quantity',
    13 => 'p.quantity',
    14 => 'p.quantity_in_stock',
    15 => 'p.price_per_unit',
    16 => 'p.retail_price',
    17 => 'p.member_price',
    18 => 'p.description',
    19 => 's.supplier_name',
    20 => 'p.picture',
    21 => 'p.insert_date',
    22 => 'p.update_date',
    23 => 'p.approve_status',
    24 => 'p.id'
];

$orderColumnIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 0;
$orderDir = isset($_POST['order'][0]['dir']) && strtolower($_POST['order'][0]['dir']) === 'desc' ? 'DESC' : 'ASC';

$orderColumn = isset($columns[$orderColumnIndex]) ? $columns[$orderColumnIndex] : 'p.id';

$where = " WHERE (p.quantity_in_stock <= 0 OR p.approve_status = 'N') ";

if ($searchValue !== '') {
    $safeSearch = addslashes($searchValue);
    $where .= " AND (
        p.barcode LIKE '%$safeSearch%' OR
        p.genaric_name LIKE '%$safeSearch%' OR
        p.brand_name LIKE '%$safeSearch%' OR
        dc.cat_name LIKE '%$safeSearch%' OR
        s.supplier_name LIKE '%$safeSearch%' OR
        p.approve_status LIKE '%$safeSearch%'
    ) ";
}

$baseFrom = "
    FROM tbl_product p
    LEFT JOIN tbl_drug_category dc ON dc.id = p.category
    LEFT JOIN tbl_supplier s ON s.id = p.supplier_id
    LEFT JOIN tbl_user_login cu ON cu.id = p.user_insert
    LEFT JOIN tbl_user_login uu ON uu.id = p.user_update
";

$totalSql = "
    SELECT COUNT(*) 
    FROM tbl_product p
    WHERE (p.quantity_in_stock <= 0 OR p.approve_status = 'N')
";
$recordsTotal = intval($oDB->QueryOne($totalSql));

$filterSql = "
    SELECT COUNT(*)
    $baseFrom
    $where
";
$recordsFiltered = intval($oDB->QueryOne($filterSql));

$sql = "
    SELECT
        p.id,
        cu.full_name AS createuser,
        uu.full_name AS updateuser,
        p.barcode,
        p.genaric_name,
        p.brand_name,
        dc.cat_name AS categoryid,
        p.batch_no,
        p.medicine_label,
        p.prescription_required,
        p.saleaccount_11,
        p.expiration_date,
        p.min_quantity,
        p.quantity,
        p.quantity_in_stock,
        p.price_per_unit,
        p.retail_price,
        p.member_price,
        p.description,
        s.supplier_name AS supplierid,
        p.picture,
        p.insert_date,
        p.update_date,
        p.approve_status
    $baseFrom
    $where
    ORDER BY $orderColumn $orderDir
    LIMIT $start, $length
";

$rs = $oDB->Query($sql);

$data = [];
$rownum = $start + 1;

while ($row = $rs->FetchRow(DBI_ASSOC)) {

    $prescription = $row['prescription_required'] == 'Y'
        ? '<span class="badge badge-pill badge-success"><i class="fas fa-check-circle"></i> Yes</span>'
        : '<span class="badge badge-pill badge-danger"><i class="far fa-times-circle"></i> No</span>';

    $sale11 = $row['saleaccount_11'] == 'Y'
        ? '<span class="badge badge-pill badge-success"><i class="fas fa-check-circle"></i> Yes</span>'
        : '<span class="badge badge-pill badge-danger"><i class="far fa-times-circle"></i> No</span>';

    $expiration = '';
    if (!empty($row['expiration_date'])) {
        $expirationText = date('d-m-Y', strtotime($row['expiration_date']));
        $expirationDateObj = new DateTime($row['expiration_date']);
        $twoMonthsLater = new DateTime();
        $twoMonthsLater->add(new DateInterval('P2M'));

        if ($expirationDateObj < $twoMonthsLater) {
            $expiration = '<span style="color:red">' . $expirationText . '</span>';
        } else {
            $expiration = $expirationText;
        }
    }

    $status = $row['approve_status'] == 'A'
        ? '<span class="badge badge-pill badge-success"><i class="fas fa-check-circle"></i> Active</span>'
        : '<span class="badge badge-pill badge-danger"><i class="far fa-times-circle"></i> InActive</span>';

    $tools = '
        <a class="btn btn-info btn-xs" href="product_view.php?act=view&id=' . $row['id'] . '">
            <i class="fas fa-search"></i> View
        </a>
    ';

    $data[] = [
        $rownum,
        $row['createuser'],
        $row['updateuser'],
        $row['barcode'],
        $row['genaric_name'],
        $row['brand_name'],
        $row['categoryid'],
        $row['batch_no'],
        $row['medicine_label'],
        $prescription,
        $sale11,
        $expiration,
        $row['min_quantity'],
        $row['quantity'],
        $row['quantity_in_stock'],
        $row['price_per_unit'],
        $row['retail_price'],
        $row['member_price'],
        $row['description'],
        $row['supplierid'],
        $row['picture'],
        !empty($row['insert_date']) ? date('d-m-Y', strtotime($row['insert_date'])) : '',
        !empty($row['update_date']) ? date('d-m-Y', strtotime($row['update_date'])) : '',
        $status,
        $tools
    ];

    $rownum++;
}

echo json_encode([
    "draw" => $draw,
    "recordsTotal" => $recordsTotal,
    "recordsFiltered" => $recordsFiltered,
    "data" => $data
]);