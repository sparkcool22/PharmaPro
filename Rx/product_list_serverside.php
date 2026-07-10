<?php
include '../include/config.php';
include '../include/common.php';
include '../include/setting.php';

CheckUserLogin_Fornt();

$oDB = new DBI();

$sExpireDate = $oDB->QueryOne("SELECT nom_expire FROM tbl_setting WHERE id = 1 AND approve_status = 'A' ");
if (!$sExpireDate) {
    $sExpireDate = 2;
}

$draw   = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
$start  = isset($_POST['start']) ? intval($_POST['start']) : 0;
$length = isset($_POST['length']) ? intval($_POST['length']) : 25;

$searchValue = '';
if (isset($_POST['search']['value'])) {
    $searchValue = trim($_POST['search']['value']);
}

$startDate = isset($_POST['start_date']) ? trim($_POST['start_date']) : '';
$endDate   = isset($_POST['end_date']) ? trim($_POST['end_date']) : '';

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
    11 => 'p.expiration_date',
    12 => 'p.min_quantity',
    13 => 'p.quantity',
    14 => 'p.quantity_in_stock',
    15 => 'p.price_per_unit',
    16 => 'p.retail_price',
    17 => 'p.member_price',
    18 => 'p.description',
    19 => 'sp.supplier_name',
    20 => 'p.picture',
    21 => 'p.insert_date',
    22 => 'p.update_date'
];

$orderColumnIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 0;
$orderDir = isset($_POST['order'][0]['dir']) && strtolower($_POST['order'][0]['dir']) === 'asc'
    ? 'ASC'
    : 'DESC';

$orderColumn = isset($columns[$orderColumnIndex]) ? $columns[$orderColumnIndex] : 'p.id';

$where = " WHERE p.quantity_in_stock > 0 AND p.approve_status = 'A' ";

if ($searchValue !== '') {
    $safeSearch = addslashes($searchValue);

    $where .= " AND (
        p.barcode LIKE '%{$safeSearch}%'
        OR p.genaric_name LIKE '%{$safeSearch}%'
        OR p.brand_name LIKE '%{$safeSearch}%'
        OR p.batch_no LIKE '%{$safeSearch}%'
        OR dc.cat_name LIKE '%{$safeSearch}%'
        OR sp.supplier_name LIKE '%{$safeSearch}%'
    ) ";
}

if ($startDate !== '' && $endDate !== '') {
    $safeStartDate = addslashes($startDate);
    $safeEndDate = addslashes($endDate);

    $where .= " AND DATE(p.insert_date) BETWEEN '{$safeStartDate}' AND '{$safeEndDate}' ";
}

$totalRecords = $oDB->QueryOne("
    SELECT COUNT(*)
    FROM tbl_product p
    WHERE p.quantity_in_stock > 0
      AND p.approve_status = 'A'
");

$totalFiltered = $oDB->QueryOne("
    SELECT COUNT(*)
    FROM tbl_product p
    LEFT JOIN tbl_drug_category dc ON dc.id = p.category
    LEFT JOIN tbl_supplier sp ON sp.id = p.supplier_id
    LEFT JOIN tbl_user_login cu ON cu.id = p.user_insert
    LEFT JOIN tbl_user_login uu ON uu.id = p.user_update
    {$where}
");

$sql = "
    SELECT
        p.id,
        p.barcode,
        p.genaric_name,
        p.brand_name,
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
        p.picture,
        p.insert_date,
        p.update_date,
        p.approve_status,
        IFNULL(dc.cat_name, '') AS categoryid,
        IFNULL(sp.supplier_name, '') AS supplierid,
        IFNULL(cu.full_name, '') AS createuser,
        IFNULL(uu.full_name, '') AS updateuser
    FROM tbl_product p
    LEFT JOIN tbl_drug_category dc ON dc.id = p.category
    LEFT JOIN tbl_supplier sp ON sp.id = p.supplier_id
    LEFT JOIN tbl_user_login cu ON cu.id = p.user_insert
    LEFT JOIN tbl_user_login uu ON uu.id = p.user_update
    {$where}
    ORDER BY {$orderColumn} {$orderDir}
    LIMIT {$start}, {$length}
";

$rs = $oDB->Query($sql);

$data = [];
$no = $start + 1;

while ($row = $rs->FetchRow(DBI_ASSOC)) {

    $prescriptionHtml = ($row['prescription_required'] == 'Y')
        ? '<span class="badge badge-pill badge-success"><i class="fas fa-check-circle"></i> Yes</span>'
        : '<span class="badge badge-pill badge-danger"><i class="far fa-times-circle"></i> No</span>';

    $sale11Html = ($row['saleaccount_11'] == 'Y')
        ? '<span class="badge badge-pill badge-success"><i class="fas fa-check-circle"></i> Yes</span>'
        : '<span class="badge badge-pill badge-danger"><i class="far fa-times-circle"></i> No</span>';

    $expirationHtml = '';

    if (!empty($row['expiration_date'])) {
        $expirationDateObj = new DateTime($row['expiration_date']);
        $twoMonthsLater = new DateTime();
        $twoMonthsLater->add(new DateInterval('P' . intval($sExpireDate) . 'M'));

        $expText = date('d-m-Y', strtotime($row['expiration_date']));

        if ($expirationDateObj < $twoMonthsLater) {
            $expirationHtml = '<span style="color:red">' . $expText . '</span>';
        } else {
            $expirationHtml = $expText;
        }
    }

    $insertDate = !empty($row['insert_date']) ? date('d-m-Y', strtotime($row['insert_date'])) : '';
    $updateDate = !empty($row['update_date']) ? date('d-m-Y', strtotime($row['update_date'])) : '';

    $statusHtml = '<span class="badge badge-pill badge-success"><i class="fas fa-check-circle"></i> Active</span>';

    $toolsHtml = '
        <a class="btn btn-info btn-xs" href="product_view.php?act=view&id=' . $row['id'] . '">
            <i class="fas fa-search"></i> View
        </a>
        <a class="btn btn-warning btn-xs" href="product_form.php?act=edit&id=' . $row['id'] . '">
            <i class="fas fa-pencil-alt"></i> Edit
        </a>
    ';

    $data[] = [
        'no'                         => $no,
        'createuser'                 => $row['createuser'],
        'updateuser'                 => $row['updateuser'],
        'barcode'                    => $row['barcode'],
        'genaric_name'               => $row['genaric_name'],
        'brand_name'                 => $row['brand_name'],
        'categoryid'                 => $row['categoryid'],
        'batch_no'                   => $row['batch_no'],
        'medicine_label'             => $row['medicine_label'],
        'prescription_required_html' => $prescriptionHtml,
        'saleaccount_11_html'        => $sale11Html,
        'expiration_date_html'       => $expirationHtml,
        'min_quantity'               => $row['min_quantity'],
        'quantity'                   => $row['quantity'],
        'quantity_in_stock'          => $row['quantity_in_stock'],
        'price_per_unit'             => $row['price_per_unit'],
        'retail_price'               => $row['retail_price'],
        'member_price'               => $row['member_price'],
        'description'                => $row['description'],
        'supplierid'                 => $row['supplierid'],
        'picture'                    => $row['picture'],
        'insert_date'                => $insertDate,
        'update_date'                => $updateDate,
        'status_html'                => $statusHtml,
        'tools_html'                 => $toolsHtml
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