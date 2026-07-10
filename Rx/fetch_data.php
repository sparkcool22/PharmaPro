<?php
include '../include/config.php';
include '../include/common.php';

// CheckUserLogin_Fornt();

// Read parameters

$oDB = new DBI();
$oTmp = new TemplateEngine();
$oLogin = new LoginManager();


$sUserID = isset($_SESSION['aupro_member_id']) ? $_SESSION['aupro_member_id'] : '';
$sACT = 'view';

$sStatus = isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
$sID = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
$selectedValue = $_POST['selectedValue'];
$customerValue = $_POST['sCustomer'];

$drugid = $_POST['drugid'];
$drugValue = $_POST['sDrug'];

if ($sUserID) {
    $dataUserinfo = $oDB->QueryRow("SELECT * FROM tbl_user_login WHERE id='" . $sUserID . "'", DBI_ASSOC);
    $dataUserinfo['pic_url'] = USERIMG_URL . $dataUserinfo['picture'];
}
?>

<?php if ($customerValue=='sCustomer'){ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>

<body class="hold-transition sidebar-collapse layout-top-nav">
    <div class="wrapper">
        <!-- Navbar -->
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <!-- Content Wrapper. Contains page content -->
        <!-- <div class="content-wrapper" > -->
        <!-- Content Header (Page header) -->

        <?php
      if ($sACT == 'view') {
        $dataReport = $oDB->QueryRow("SELECT * FROM tbl_customer WHERE id='" . $selectedValue . "'", DBI_ASSOC);
                
        if ($dataReport['approve_status'] == 'A') {
          $dataReport['approve_status'] = 'Active' ;
        }else{
          $dataReport['approve_status'] = 'InActive' ;
        }

        if ($dataReport['member'] == 'M') {
          $dataReport['member'] = 'Basic Member' ;
        }elseif ($dataReport['member'] == 'P'){
          $dataReport['member'] = 'Premium Member' ;
        }elseif ($dataReport['member'] == 'V'){
          $dataReport['member'] = 'VIP Member' ;
        }

        $dataReport['createuser'] = $oDB->QueryOne("SELECT full_name FROM tbl_product n1 INNER JOIN tbl_user_login n2 WHERE n1.user_insert = n2.id AND n1.id='" . $selectedValue . "' ");
        $dataReport['createuser'] = $dataReport['createuser']." ".date('d-m-Y H:i:s', strtotime($dataReport['insert_date']));
        $dataReport['updateuser'] = $oDB->QueryOne("SELECT full_name FROM tbl_product n1 INNER JOIN tbl_user_login n2 WHERE n1.user_update = n2.id AND n1.id='" . $selectedValue . "' ");
        $dataReport['updateuser'] = $dataReport['updateuser']." ".date('d-m-Y H:i:s', strtotime($dataReport['update_date']));
      }
	?>
        <!-- Main content -->
        <section class="content pt-2 px-1 ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-olive" style="background-color: white; color: #333;">

                            <div class="row mt-1">
                                <div class="col-md-12">

                                    <div class="card-body" style="margin-bottom:-50px">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> Name</strong>
                                                <small>(ชื่อลูกค้า)</small>
                                                <p class="text-muted pl-4">
                                                    <?php if ($dataReport['customer_name']) { ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['customer_name'] ?>
                                                    <?php }else{ ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <span style="font-style: italic; opacity: 0.5;">No
                                                        Information</span>
                                                    <?php } ?>
                                                </p>
                                                <hr>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> Address</strong>
                                                <small>(ที่อยู่ลูกค้า)</small>
                                                <p class="text-muted pl-4">
                                                    <?php if ($dataReport['customer_address']) { ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['customer_address'] ?>
                                                    <?php }else{ ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <span style="font-style: italic; opacity: 0.5;">No
                                                        Information</span>
                                                    <?php } ?>
                                                </p>
                                                <hr>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> Phone</strong>
                                                <small>(โทรศัพท์)</small>
                                                <p class="text-muted pl-4">
                                                    <?php if ($dataReport['customer_phone']) { ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['customer_phone'] ?>
                                                    <?php }else{ ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <span style="font-style: italic; opacity: 0.5;">No
                                                        Information</span>
                                                    <?php } ?>
                                                </p>
                                                <hr>
                                            </div>
                                            <div class="col-md-6">
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> Email</strong>
                                                <small>(อีเมล)</small>
                                                <p class="text-muted pl-4">
                                                    <?php if ($dataReport['customer_email']) { ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['customer_email'] ?>
                                                    <?php }else{ ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <span style="font-style: italic; opacity: 0.5;">No
                                                        Information</span>
                                                    <?php } ?>
                                                </p>
                                                <hr>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> Remark</strong>
                                                <small>(หมายเหตุ)</small>
                                                <p class="text-muted pl-4">
                                                    <?php if ($dataReport['customer_remark']) { ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['customer_remark'] ?>
                                                    <?php }else{ ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <span style="font-style: italic; opacity: 0.5;">No
                                                        Information</span>
                                                    <?php } ?>
                                                </p>
                                                <hr>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> Member</strong>
                                                <small>(สมาชิก)</small>
                                                <p class="text-muted pl-4">
                                                    <?php if ($dataReport['member']) { ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['member'] ?>
                                                    <?php }else{ ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <span style="font-style: italic; opacity: 0.5;">No
                                                        Information</span>
                                                    <?php } ?>
                                                </p>
                                                <hr>
                                            </div>
                                            <div class="col-md-6">
                                                <?php if ($dataReport['approve_status']=='Active') { ?>
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> Status</strong>
                                                <small>(สถานะ)</small><i class="fa-solid fa-circle fa-beat ml-2"
                                                    style="color: green;"></i>
                                                <p class="text-muted pl-4">
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['approve_status'] ?>
                                                    <?php }else{ ?>
                                                    <strong><i class="fa-solid fa-file-prescription mr-1"
                                                            style='font-size:14px'></i> Status</strong>
                                                    <small>(สถานะ)</small><i class="fa-solid fa-circle fa-beat ml-2"
                                                        style="color: red;"></i>
                                                <p class="text-muted pl-4">
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['approve_status'] ?>
                                                    <?php } ?>
                                                </p>
                                                <hr>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> User Create</strong>
                                                <small>(ผู้นำเข้าข้อมูล)</small>
                                                <p class="text-muted pl-4">
                                                    <?php if ($dataReport['user_insert']) { ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['createuser'] ?>
                                                    <?php }else{ ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <span style="font-style: italic; opacity: 0.5;">No
                                                        Information</span>
                                                    <?php } ?>
                                                </p>
                                                <hr>
                                            </div>
                                            <div class="col-md-6">
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> User Update</strong>
                                                <small>(ผู้อัพเดดข้อมูล)</small>
                                                <p class="text-muted pl-4">
                                                    <?php if ($dataReport['user_update']) { ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['updateuser'] ?>
                                                    <?php }else{ ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <span style="font-style: italic; opacity: 0.5;">No
                                                        Information</span>
                                                    <?php } ?>
                                                </p>
                                                <hr>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- /.card-body -->

                                </div> <!-- col 12 -->

                                <!-- Second  -->
                                <div class="col-md-6">
                                    <div class="card-body">

                                    </div> <!-- card-body  -->

                                </div> <!-- col 6 -->

                            </div> <!-- row class="row mt-3 mx-3"-->
                        </div> <!-- card card-info -->
                    </div> <!-- col 12 -->
                </div> <!-- row -->
            </div> <!-- container-fluid  -->
        </section>


        <!-- ---Main content -->
        <!-- </div> -->

        <!-- /.content-wrapper -->

    </div>
    <!-- ./wrapper -->

</body>

</html>
<?php } ?>
<?php if ($drugValue=='sDrug'){ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body class="hold-transition sidebar-collapse layout-top-nav">
    <div class="wrapper">

        <?php
      if ($sACT == 'view') {
        $dataReport = $oDB->QueryRow("SELECT * FROM tbl_product WHERE id='" . $drugid . "'", DBI_ASSOC);

        $dataReport['drugcategory'] = $oDB->QueryOne("SELECT cat_name FROM tbl_product n1 INNER JOIN tbl_drug_category n2 WHERE n1.category  = n2.id AND n1.id='" . $drugid . "' ");
        $dataReport['suppliername'] = $oDB->QueryOne("SELECT supplier_name FROM tbl_product n1 INNER JOIN tbl_supplier n2 WHERE n1.supplier_id  = n2.id AND n1.id='" . $drugid . "' ");
        
        if ($dataReport['saleaccount_11'] == 'Y') {
          $dataReport['saleaccount_11'] = 'Yes' ;
        }else{
          $dataReport['saleaccount_11'] = 'No' ;
        }

        if ($dataReport['prescription_required'] == 'Y') {
          $dataReport['prescription_required'] = 'Yes' ;
        }else{
          $dataReport['prescription_required'] = 'No' ;
        }
        
        if ($dataReport['approve_status'] == 'A') {
          $dataReport['approve_status'] = 'Active' ;
        }else{
          $dataReport['approve_status'] = 'InActive' ;
        }

        $dataReport['createuser'] = $oDB->QueryOne("SELECT full_name FROM tbl_product n1 INNER JOIN tbl_user_login n2 WHERE n1.user_insert = n2.id AND n1.id='" . $drugid . "' ");
        $dataReport['createuser'] = $dataReport['createuser']." ".date('d-m-Y H:i:s', strtotime($dataReport['insert_date']));
        $dataReport['updateuser'] = $oDB->QueryOne("SELECT full_name FROM tbl_product n1 INNER JOIN tbl_user_login n2 WHERE n1.user_update = n2.id AND n1.id='" . $drugid . "' ");
        $dataReport['updateuser'] = $dataReport['updateuser']." ".date('d-m-Y H:i:s', strtotime($dataReport['update_date']));
      }
	?>
        <!-- Main content -->
        <section class="content pt-1 px-1">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-olive" style="background-color: white; color: #333;">

                            <div class="row mt-1 mx-1">
                                <div class="col-md-8">

                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> Barcode</strong>
                                                <small>(บาร์โค้ด)</small>
                                                <p class="text-muted pl-4">
                                                    <?php if ($dataReport['barcode']) { ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['barcode'] ?>
                                                    <?php }else{ ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <span style="font-style: italic; opacity: 0.5;">No
                                                        Information</span>
                                                    <?php } ?>
                                                </p>
                                                <hr>
                                            </div>
                                            <div class="col-md-6">
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> Batch No</strong>
                                                <small>(หมายเลขล็อตของยา)</small>
                                                <p class="text-muted pl-4">
                                                    <?php if ($dataReport['batch_no']) { ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['batch_no'] ?>
                                                    <?php }else{ ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <span style="font-style: italic; opacity: 0.5;">No
                                                        Information</span>
                                                    <?php } ?>
                                                </p>
                                                <hr>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> Genaric Name</strong>
                                                <small>(ชื่อสามัญทางยา)</small>
                                                <p class="text-muted pl-4">
                                                    <?php if ($dataReport['genaric_name']) { ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['genaric_name'] ?>
                                                    <?php }else{ ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <span style="font-style: italic; opacity: 0.5;">No
                                                        Information</span>
                                                    <?php } ?>
                                                </p>
                                                <hr>
                                            </div>
                                            <div class="col-md-6">
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> Brand Name</strong>
                                                <small>(ชื่อทางการค้าของยา)</small>
                                                <p class="text-muted pl-4">
                                                    <?php if ($dataReport['brand_name']) { ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['brand_name'] ?>
                                                    <?php }else{ ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <span style="font-style: italic; opacity: 0.5;">No
                                                        Information</span>
                                                    <?php } ?>
                                                </p>
                                                <hr>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> Drug Category</strong>
                                                <small>(ประเภทของยา)</small>
                                                <p class="text-muted pl-4">
                                                    <?php if ($dataReport['drugcategory']) { ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['drugcategory'] ?>
                                                    <?php }else{ ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <span style="font-style: italic; opacity: 0.5;">No
                                                        Information</span>
                                                    <?php } ?>
                                                </p>
                                                <hr>
                                            </div>
                                            <div class="col-md-6">
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> Prescription Required</strong>
                                                <small>(ต้องใช้ใบสั่งยาหรือไม่)</small>
                                                <p class="text-muted pl-4">
                                                    <?php if ($dataReport['prescription_required']) { ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['prescription_required'] ?>
                                                    <?php }else{ ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <span style="font-style: italic; opacity: 0.5;">No
                                                        Information</span>
                                                    <?php } ?>
                                                </p>
                                                <hr>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> Quantity</strong>
                                                <small>(จำนวนที่รับเข้าครั้งแรก)</small>
                                                <p class="text-muted pl-4">
                                                    <?php if ($dataReport['quantity']) { ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['quantity'] ?>
                                                    <?php }else{ ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <span style="font-style: italic; opacity: 0.5;">0</span>
                                                    <?php } ?>
                                                </p>
                                                <hr>
                                            </div>
                                            <div class="col-md-6">
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> Quantity In Stock</strong>
                                                <small>(จำนวนคงเหลือในคลัง)</small>
                                                <p class="text-muted pl-4">
                                                    <?php if ($dataReport['quantity_in_stock']) { ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['quantity_in_stock'] ?>
                                                    <?php }else{ ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <span style="font-style: italic; opacity: 0.5;">0</span>
                                                    <?php } ?>
                                                </p>
                                                <hr>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> Price Per Unit</strong>
                                                <small>(ราคาต่อหน่วย)</small>
                                                <p class="text-muted pl-4">
                                                    <?php if ($dataReport['price_per_unit']) { ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['price_per_unit'] ?>
                                                    <?php }else{ ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <span style="font-style: italic; opacity: 0.5;">0</span>
                                                    <?php } ?>
                                                </p>
                                                <hr>
                                            </div>
                                            <div class="col-md-6">
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> Retail Price</strong>
                                                <small>(ราคาขายปลีก)</small>
                                                <p class="text-muted pl-4">
                                                    <?php if ($dataReport['retail_price']) { ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['retail_price'] ?>
                                                    <?php }else{ ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <span style="font-style: italic; opacity: 0.5;">0</span>
                                                    <?php } ?>
                                                </p>
                                                <hr>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> Member Price</strong>
                                                <small>(ราคาขายส่ง)</small>
                                                <p class="text-muted pl-4">
                                                    <?php if ($dataReport['member_price']) { ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['member_price'] ?>
                                                    <?php }else{ ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <span style="font-style: italic; opacity: 0.5;">0</span>
                                                    <?php } ?>
                                                </p>
                                                <hr>
                                            </div>
                                            <div class="col-md-6">
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> Minimum Quantity</strong>
                                                <small>(จำนวนคงเหลือที่น้อยที่สุด)</small>
                                                <p class="text-muted pl-4">
                                                    <?php if ($dataReport['min_quantity']) { ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['min_quantity']; ?>
                                                    <?php }else{ ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <span style="font-style: italic; opacity: 0.5;">0</span>
                                                    <?php } ?>
                                                </p>
                                                <hr>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> Expiration Date</strong>
                                                <small>(วันหมดอายุ)</small>
                                                <p class="text-muted pl-4">
                                                    <?php if ($dataReport['expiration_date']) { ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo date('d-m-Y', strtotime($dataReport['expiration_date'])); ?>
                                                    <?php }else{ ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <span style="font-style: italic; opacity: 0.5;">No
                                                        Information</span>
                                                    <?php } ?>
                                                </p>
                                                <hr>
                                            </div>
                                            <div class="col-md-6">
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> Supplier</strong>
                                                <small>(ผู้จัดจำหน่าย)</small>
                                                <p class="text-muted pl-4">
                                                    <?php if ($dataReport['suppliername']) { ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['suppliername'] ?>
                                                    <?php }else{ ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <span style="font-style: italic; opacity: 0.5;">No
                                                        Information</span>
                                                    <?php } ?>
                                                </p>
                                                <hr>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <?php if ($dataReport['saleaccount_11']=='Yes') { ?>
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> ขย11</strong> <small>(ยาเฉพาะ
                                                    ต้องทำเอกสารการขาย)</small><i
                                                    class="fa-solid fa-circle fa-beat ml-2" style="color: green;"></i>
                                                <p class="text-muted pl-4">
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['saleaccount_11'] ?>
                                                    <?php }else{ ?>
                                                    <strong><i class="fa-solid fa-file-prescription mr-1"
                                                            style='font-size:14px'></i> ขย11</strong> <small>(ยาเฉพาะ
                                                        ต้องทำเอกสารการขาย)</small><i
                                                        class="fa-solid fa-circle fa-beat ml-2" style="color: red;"></i>
                                                <p class="text-muted pl-4">
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['saleaccount_11'] ?>
                                                    <?php } ?>
                                                </p>
                                                <hr>
                                            </div>
                                            <div class="col-md-6">
                                                <?php if ($dataReport['approve_status']=='Active') { ?>
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> Status</strong>
                                                <small>(สถานะ)</small><i class="fa-solid fa-circle fa-beat ml-2"
                                                    style="color: green;"></i>
                                                <p class="text-muted pl-4">
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['approve_status'] ?>
                                                    <?php }else{ ?>
                                                    <strong><i class="fa-solid fa-file-prescription mr-1"
                                                            style='font-size:14px'></i> Status</strong>
                                                    <small>(สถานะ)</small><i class="fa-solid fa-circle fa-beat ml-2"
                                                        style="color: red;"></i>
                                                <p class="text-muted pl-4">
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['approve_status'] ?>
                                                    <?php } ?>
                                                </p>
                                                <hr>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> User Create</strong>
                                                <small>(ผู้นำเข้าข้อมูล)</small>
                                                <p class="text-muted pl-4">
                                                    <?php if ($dataReport['user_insert']) { ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['createuser'] ?>
                                                    <?php }else{ ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <span style="font-style: italic; opacity: 0.5;">No
                                                        Information</span>
                                                    <?php } ?>
                                                </p>
                                                <hr>
                                            </div>
                                            <div class="col-md-6">
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> User Update</strong>
                                                <small>(ผู้อัพเดดข้อมูล)</small>
                                                <p class="text-muted pl-4">
                                                    <?php if ($dataReport['user_update']) { ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['updateuser'] ?>
                                                    <?php }else{ ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <span style="font-style: italic; opacity: 0.5;">No
                                                        Information</span>
                                                    <?php } ?>
                                                </p>
                                                <hr>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- /.card-body -->

                                </div> <!-- col 12 -->

                                <!-- Second  -->
                                <div class="col-md-4">
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> Medicine Label</strong>
                                                <small>(ฉลากยา)</small>
                                                <p class="text-muted pl-4">
                                                    <?php if ($dataReport['medicine_label']) { ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['medicine_label'] ?>
                                                    <?php }else{ ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <span style="font-style: italic; opacity: 0.5;">No
                                                        Information</span>
                                                    <?php } ?>
                                                </p>
                                                <hr>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> Description</strong>
                                                <small>(รายละเอียดเพิ่มเติมของยา)</small>
                                                <p class="text-muted pl-4">
                                                    <?php if ($dataReport['description']) { ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <?php echo $dataReport['description'] ?>
                                                    <?php }else{ ?>
                                                    <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i>
                                                    <span style="font-style: italic; opacity: 0.5;">No
                                                        Information</span>
                                                    <?php } ?>
                                                </p>
                                                <hr>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <strong><i class="fa-solid fa-file-prescription mr-1"
                                                        style='font-size:14px'></i> Picture</strong>
                                                <small>(รูปภาพของยา)</small>
                                                <p class="text-muted px-4 py-2">
                                                    <!-- <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <?php echo $dataReport['description'] ?> -->
                                                    <?php if ($dataReport["picture"] != '') { ?>
                                                    <img src=<?php echo "../upload/drug_image/" . $dataReport['picture'] ?>
                                                        class="img-fluid img-thumbnail"
                                                        style="width: auto; height: 300px;" alt="Photo" />
                                                    <?php } else { ?>
                                                    <img src="../upload/drug_image/img_not.gif" class="img-fluid"
                                                        alt="Photo">
                                                    <?php } ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div> <!-- card-body  -->

                                </div> <!-- col 6 -->
                            </div> <!-- row class="row mt-3 mx-3"-->
                        </div> <!-- card card-info -->
                    </div> <!-- col 12 -->
                </div> <!-- row -->
            </div> <!-- container-fluid  -->
        </section>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

</body>

</html>
<?php } ?>