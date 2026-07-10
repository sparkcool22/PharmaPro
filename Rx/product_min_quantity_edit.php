<?php
include '../include/config.php';
include '../include/common.php';
include '../include/setting.php';

CheckUserLogin_Fornt();

// Read parameters
$sACT = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';

$oDB = new DBI();

$sUserID = isset($_SESSION['aupro_member_id']) ? $_SESSION['aupro_member_id'] : '';
$sACT = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';

$sStatus = isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
$sID = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';

if ($sUserID) {
    $dataUserinfo = $oDB->QueryRow("SELECT * FROM tbl_user_login WHERE id='" . $sUserID . "'", DBI_ASSOC);
    $dataUserinfo['pic_url'] = USERIMG_URL . $dataUserinfo['picture'];
}

$axSql_Drug_Category = $oDB->Query("SELECT * FROM tbl_drug_category WHERE approve_status = 'A' ");
while ($asResult = $axSql_Drug_Category->FetchRow(DBI_ASSOC)) {
  $asDrugCategory[] = $asResult;
}

$axSql_Product_list = $oDB->Query("SELECT * FROM tbl_product ORDER BY approve_status ASC");
while ($asResult = $axSql_Product_list->FetchRow(DBI_ASSOC)) {
  $asProductList[] = $asResult;
}

$axSql_Supplier = $oDB->Query("SELECT * FROM tbl_supplier WHERE approve_status = 'A' ");
while ($asResult = $axSql_Supplier->FetchRow(DBI_ASSOC)) {
  $asSupplier[] = $asResult;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PharmaPro: RoongRuang Pharmacy</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/PharmaPro/alte/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/PharmaPro/alte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="/PharmaPro/alte/plugins/daterangepicker/daterangepicker.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="/PharmaPro/alte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Theme style -->

    <link rel="stylesheet" href="/PharmaPro/alte/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/PharmaPro/alte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">


    <link rel="stylesheet" href="/PharmaPro/alte/plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="/PharmaPro/alte/dist/css/adminlte.min.css">

    <link rel="stylesheet" href="../public/customCSS/custom_css.css">

    <script src="/PharmaPro/alte/plugins/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="hold-transition sidebar-collapse layout-top-nav">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include("l_main_head.php"); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include("l_menu.php"); ?>


        <?php
		if ($sACT == 'new') {
			$action = 'add';
		} elseif ($sACT == 'add') {
			$_POST['du_insert_date'] = 'SYSDATE()';
			$_POST['du_user_insert'] = $sUserID;
			$_POST['du_expiration_date'] = date('Y-m-d', strtotime($_POST['du_expiration_date']));
	
			// upload picture
			$upload = $_FILES['picture']['name'];
			if ($upload <> '') {   //not select file
				//โฟลเดอร์ที่จะ upload file เข้าไป 
				$path = "../upload/drug_image/";

				//เอาชื่อไฟล์เก่าออกให้เหลือแต่นามสกุล
				$type = strrchr($_FILES['picture']['name'], ".");

				//ตั้งชื่อไฟล์ใหม่โดยเอาเวลาไว้หน้าชื่อไฟล์เดิม
				$newname = date('ymdHis') . $numrand . $type;
				$path_copy = $path . $newname;
				//$path_link="fileupload/".$newname;
				move_uploaded_file($_FILES['picture']['tmp_name'], $path_copy);
				$_POST['du_picture'] = $newname;
			}

			$asSetData = array();
			foreach ($_POST as $sKey => $sVal) {
				if ((substr($sKey, 0, 3) == 'du_') && ($sVal != '')) {
					$sKey = substr($sKey, 3);
					$asSetData[$sKey] = $sVal;
				}
			}

			$sField = '';
			$sValue = '';
			foreach ($asSetData as $sKey => $sVal) {
				if (in_array($sKey, array('id', 'insert_date'))) {
					$sValue .= $sVal . ',';
				} else {
					$sValue .= '\'' . $sVal . '\',';
				}
				$sField .= $sKey . ',';
			}
			$sField = substr($sField, 0, -1);
			$sValue = substr($sValue, 0, -1);

			$inSql = "INSERT INTO tbl_product (" . $sField . ") VALUES (" . $sValue . ")";
			$oDB->Execute($inSql);
			if ($inSql) {
				echo "
				<script>
					window.location.href = 'product_list.php';
				</script>
				";
				exit;
			} else {
				$asPost = array();
				foreach ($_POST as $sKey => $sVal) {
					if (substr($sKey, 0, 3) == 'du_') {
						$sKey = substr($sKey, 3);
						$asPost[$sKey] = $sVal;
					} else {
						$asPost[$sKey] = $sVal;
					}
				}

				$action = 'add';
			}
		} elseif ($sACT == 'edit') {
			$axSql = $oDB->Query("SELECT * FROM tbl_product WHERE id='" . $sID . "' ");
			while ($asResult = $axSql->FetchRow(DBI_ASSOC)) {

				$asData = $asResult;
			}

			$action = 'update';
		} elseif ($sACT == 'update') {
			$_POST['du_update_date'] = 'SYSDATE()';
			$_POST['du_user_update'] = $sUserID;
			$_POST['du_expiration_date'] = date('Y-m-d', strtotime($_POST['du_expiration_date']));

			//upload picture

			$upload = $_FILES['picture']['name'];
			if ($upload <> '') {   //not select file
				//โฟลเดอร์ที่จะ upload file เข้าไป 
				$path = "../upload/drug_image/";

				//เอาชื่อไฟล์เก่าออกให้เหลือแต่นามสกุล
				$type = strrchr($_FILES['picture']['name'], ".");

				//ตั้งชื่อไฟล์ใหม่โดยเอาเวลาไว้หน้าชื่อไฟล์เดิม
				$newname = date('ymdHis') . $numrand . $type;
				$path_copy = $path . $newname;
				//$path_link="fileupload/".$newname;
				move_uploaded_file($_FILES['picture']['tmp_name'], $path_copy);
				$_POST['du_picture'] = $newname;
			}

			$asSetData = array();
			foreach ($_POST as $sKey => $sVal) {
				if ((substr($sKey, 0, 3) == 'du_') && ($sVal != '')) {
					$sKey = substr($sKey, 3);
					$asSetData[$sKey] = $sVal;
				}
			}

			$sSetDataUpdate = '';
			foreach ($asSetData as $sKey => $sVal) {
				if ($sKey != 'id') {
					if (in_array($sKey, array('id', 'update_date'))) {
						$sSetDataUpdate .= $sKey . '=' . $sVal . ',';
					} else {
						$sSetDataUpdate .= $sKey . '=' . '\'' . $sVal . '\',';
					}
				}
			}
			$sSetDataUpdate = substr($sSetDataUpdate, 0, -1);
			$upSql = "UPDATE tbl_product SET " . $sSetDataUpdate . " WHERE id='" . $sID . "'";
			$result = $oDB->Execute($upSql);
			if ($result) {
				echo "
				<script>
					window.location.href = 'product_min_quantity.php';
				</script>
				";
				exit;
					} else {
				$asPost = array();
				foreach ($_POST as $sKey => $sVal) {
					if (substr($sKey, 0, 3) == 'du_') {
						$sKey = substr($sKey, 3);
						$asPost[$sKey] = $sVal;
					} else {
						$asPost[$sKey] = $sVal;
					}
				}
			}
		}
		?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            <!-- Main content -->
            <section class="content pt-3 px-4">
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-12">
                            <form name="dataform" id="dataform" action="" method="post" enctype="multipart/form-data">
                                <div class="card card-info">
                                    <div class="card-header"
                                        style="display: flex; justify-content: space-between; align-items: center;">
                                        <h3 class="card-title">Create/Edit Drug Info Form</h3>
                                        <strong style="margin-left: auto;"><a href="product_list.php">Drug Information
                                                List</a></strong>
                                    </div>
                                    <?php  if ($sACT == 'new'){ ?>
                                    <div class="row pt-3 pl-4">
                                        <div class="col-sm-12 d-flex align-items-center">
                                            <div class="form-group mb-0">
                                                <select class="form-control select2" name="search_product"
                                                    id="search_product" style="width: 450px;">
                                                    <option value="">ค้นหาข้อมูลยา</option>
                                                    <?php foreach ($asProductList as $sProductList) { ?>
                                                    <option value="<?php echo $sProductList['id'] ?>">
                                                        <?php echo $sProductList['brand_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <span class="ml-2" style="color:red">* กรุณาเลือกข้อมูล
                                                เพื่อเพิ่มข้อมูลยาใหม่
                                                โดยการใช้ข้อมูลเดิมที่สำคัญบางส่วน
                                                โดยไม่ต้องพิมพ์ใหม่ทั้งหมด</span>
                                        </div>
                                    </div>
                                    <hr>
                                    <?php } ?>

                                    <div class="col-sm-12">
                                        <div class="row mt-3 mx-3">

                                            <!-- first -->
                                            <div class="col-sm-6">

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Barcode <small>(บาร์โค้ด)</small></label>
                                                            <input type="text" name="du_barcode" id="du_barcode"
                                                                value="<?php echo isset($asData['barcode']) ? $asData['barcode'] : ''; ?>"
                                                                class="form-control" placeholder="Barcode ...">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Batch No <small>(หมายเลขล็อตของยา)</small><span
                                                                    style="color:red"> *</span></label>
                                                            <input type="text" name="du_batch_no" id="du_batch_no"
                                                                value="<?php echo isset($asData['batch_no']) ? $asData['batch_no'] : ''; ?>"
                                                                class="form-control" placeholder="Batch No ..." require>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Genaric Name <small>(ชื่อสามัญทางยา)</small><span
                                                                    style="color:red"> *</span></label>
                                                            <input type="text" name="du_genaric_name"
                                                                id="du_genaric_name"
                                                                value="<?php echo isset($asData['genaric_name']) ? $asData['genaric_name'] : ''; ?>"
                                                                class="form-control" placeholder="Genaric Name ..."
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Brand Name <small>(ชื่อทางการค้าของยา)</small><span
                                                                    style="color:red"> *</span></label>
                                                            <input type="text" name="du_brand_name" id="du_brand_name"
                                                                value="<?php echo isset($asData['brand_name']) ? $asData['brand_name'] : ''; ?>"
                                                                class="form-control" placeholder="Brand Name ..."
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Drug Category <small>(ประเภทของยา)</small><span
                                                                    style="color:red"> *</span></label>
                                                            <select class="form-control" name="du_category"
                                                                id="du_category" required>
                                                                <option value="">Choose Drug Category</option>
                                                                <?php foreach ($asDrugCategory as $sDrugCategory) { ?>
                                                                <?php if ($asData['category'] == $sDrugCategory['id']) { ?>
                                                                <option value="<?php echo $sDrugCategory['id'] ?>"
                                                                    selected><?php echo $sDrugCategory['cat_name'] ?>
                                                                </option>
                                                                <?php } else { ?>
                                                                <option value="<?php echo $sDrugCategory['id'] ?>">
                                                                    <?php echo $sDrugCategory['cat_name'] ?></option>
                                                                <?php } ?>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Prescription Required
                                                                <small>(ต้องใช้ใบสั่งยาหรือไม่)</small></label>
                                                            <select name="du_prescription_required"
                                                                id="du_prescription_required" class="form-control">
                                                                <?php
										foreach ($asPrescription as $key => $value) :
											if ($key == $asData['prescription_required']) {
												echo '<option selected=selected value= "' . $key . '">' . $value . '</option>'; //close your tags!!
											} else {
												echo '<option value="' . $key . '">' . $value . '</option>'; //close your tags!!	
											}
										endforeach;
										?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Quantity
                                                                <small>(จำนวนที่รับเข้าครั้งแรก)</small><span
                                                                    style="color:red"> *</span></label>
                                                            <input type="number" name="du_quantity" id="du_quantity"
                                                                value="<?php echo isset($asData['quantity']) ? $asData['quantity'] : ''; ?>"
                                                                class="form-control" placeholder="Quantity ..."
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Quantity In Stock
                                                                <small>(จำนวนคงเหลือในคลัง)</small><span
                                                                    style="color:red"> *</span></label>
                                                            <input type="number" name="du_quantity_in_stock"
                                                                id="du_quantity_in_stock"
                                                                value="<?php echo isset($asData['quantity_in_stock']) ? $asData['quantity_in_stock'] : ''; ?>"
                                                                class="form-control" placeholder="Quantity In Stock ..."
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Price Per Unit <small>(ราคาต่อหน่วย)</small><span
                                                                    style="color:red"> *</span></label>
                                                            <input type="number" name="du_price_per_unit"
                                                                id="du_price_per_unit"
                                                                value="<?php echo isset($asData['price_per_unit']) ? $asData['price_per_unit'] : ''; ?>"
                                                                class="form-control" placeholder="Price Per Unit ..."
                                                                step="0.01" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Retail Price <small>(ราคาขายปลีก)</small><span
                                                                    style="color:red"> *</span></label>
                                                            <input type="number" name="du_retail_price"
                                                                id="du_retail_price"
                                                                value="<?php echo isset($asData['retail_price']) ? $asData['retail_price'] : ''; ?>"
                                                                class="form-control" placeholder="Retail Price ..."
                                                                step="0.01" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Member Price <small>(ราคาขายส่ง)</small><span
                                                                    style="color:red"> *</span></label>
                                                            <input type="number" name="du_member_price"
                                                                id="du_member_price"
                                                                value="<?php echo isset($asData['member_price']) ? $asData['member_price'] : ''; ?>"
                                                                class="form-control" placeholder="Member Price ..."
                                                                step="0.01" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Minimum Quantity
                                                                <small>(จำนวนคงเหลือที่น้อยที่สุด)</small><span
                                                                    style="color:red"> *</span></label>
                                                            <input type="number" name="du_min_quantity"
                                                                id="du_min_quantity"
                                                                value="<?php echo isset($asData['min_quantity']) ? $asData['min_quantity'] : ''; ?>"
                                                                class="form-control" placeholder="Minimum Quantity ..."
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Expiration Date <small>(วันหมดอายุ)</small><span
                                                                    style="color:red"> *</span></label>
                                                            <div class="input-group date" id="reservationdate"
                                                                data-target-input="nearest">
                                                                <input type="text" id="du_expiration_date"
                                                                    name="du_expiration_date"
                                                                    value="<?php echo isset($asData['expiration_date']) ? DateTime::createFromFormat('Y-m-d', $asData['expiration_date'])->format('d-m-Y') : ''; ?>"
                                                                    class="form-control datetimepicker-input"
                                                                    data-target="#reservationdate" required />
                                                                <div class="input-group-append"
                                                                    data-target="#reservationdate"
                                                                    data-toggle="datetimepicker">
                                                                    <div class="input-group-text"><i
                                                                            class="fa fa-calendar"></i></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Supplier <small>(ผู้จัดจำหน่าย)</small><span
                                                                    style="color:red"> *</span></label>
                                                            <select class="form-control" name="du_supplier_id"
                                                                id="du_supplier_id" required>
                                                                <option value="">Choose Supplier</option>
                                                                <?php foreach ($asSupplier as $sSupplier) { ?>
                                                                <?php if ($asData['supplier_id'] == $sSupplier['id']) { ?>
                                                                <option value="<?php echo $sSupplier['id'] ?>" selected>
                                                                    <?php echo $sSupplier['supplier_name'] ?></option>
                                                                <?php } else { ?>
                                                                <option value="<?php echo $sSupplier['id'] ?>">
                                                                    <?php echo $sSupplier['supplier_name'] ?></option>
                                                                <?php } ?>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>ขย11 <small>(ยาเฉพาะ
                                                                    ต้องทำเอกสารการขาย)</small></label>
                                                            <select name="du_saleaccount_11" id="du_saleaccount_11"
                                                                class="form-control">
                                                                <?php
										foreach ($asSA11 as $key => $value) :
											if ($key == $asData['saleaccount_11']) {
												echo '<option selected=selected value= "' . $key . '">' . $value . '</option>'; //close your tags!!
											} else {
												echo '<option value="' . $key . '">' . $value . '</option>'; //close your tags!!	
											}
										endforeach;
										?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Status <small>(สถานะ)</small></label>
                                                            <select name="du_approve_status" id="du_approve_status"
                                                                class="form-control">
                                                                <?php
										foreach ($asStatus as $key => $value) :
											if ($key == $asData['approve_status']) {
												echo '<option selected=selected value= "' . $key . '">' . $value . '</option>'; //close your tags!!
											} else {
												echo '<option value="' . $key . '">' . $value . '</option>'; //close your tags!!	
											}
										endforeach;
										?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div> <!-- col-sm-6  -->
                                            <!-- first -->


                                            <!-- second -->
                                            <div class="col-sm-6">

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Medicine Label <small>(ฉลากยา)</small></label>
                                                            <textarea name="du_medicine_label" id="du_medicine_label"
                                                                rows="10"> <?php echo isset($asData['medicine_label']) ? $asData['medicine_label'] : ''; ?> </textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Description
                                                                <small>(รายละเอียดเพิ่มเติมของยา)</small></label>
                                                            <textarea name="du_description"
                                                                id="du_description"> <?php echo isset($asData['description']) ? $asData['description'] : ''; ?> </textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <?php if ($asData["picture"] != '') { ?>
                                                                <img src=<?php echo "../upload/drug_image/" . $asData['picture'] ?>
                                                                    class="img-fluid img-thumbnail"
                                                                    style="width: auto; height: 300px;" alt="Photo" />
                                                                <?php } else { ?>
                                                                <img src="../upload/drug_image/img_not.gif"
                                                                    class="img-fluid" alt="Photo">
                                                                <?php } ?>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-md-10">
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input"
                                                                            id="picture" name="picture">
                                                                        <label class="custom-file-label"
                                                                            for="picture">Choose Picture</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- second -->


                                        </div> <!-- row -->
                                    </div> <!-- col-sm-12 -->
                                    <!-- third -->
                                    <div class="card-footer">
                                        <button type="button" id="saveBtn" class="btn btn-success btn-block"
                                            value="save">Save</button>
                                        <?php if ($action != 'add') { ?>
                                        <input name="du_id" type="hidden" id="du_id" value="1" />
                                        <?php } ?>
                                        <input name="act" type="hidden" id="act" value="<?php echo $action ?>" />
                                    </div>
                                </div> <!-- card card-info -->
                            </form>
                        </div> <!-- col-12 -->
                    </div> <!-- row -->

                </div> <!-- container-fluid  -->

            </section>

        </div>

        <!-- /.content-wrapper -->

        <?php include("l_footer.php");  ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <!-- AdminLTE App -->

    <!-- Script ตาราง -->
    <script src="/PharmaPro/alte/plugins/jquery/jquery.min.js"></script>

    <!-- <script src="/PharmaPro/alte/plugins/datatables/jquery.dataTables.min.js"></script> -->
    <script src="/PharmaPro/alte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>


    <script src="/PharmaPro/alte/plugins/select2/js/select2.full.min.js"></script>
    <!-- InputMask -->
    <script src="/PharmaPro/alte/plugins/moment/moment.min.js"></script>
    <!-- date-range-picker -->
    <script src="/PharmaPro/alte/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="/PharmaPro/alte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>



    <script src="/PharmaPro/alte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="/PharmaPro/alte/plugins/summernote/summernote-bs4.min.js"></script>

    <!-- AdminLTE App -->
    <script src="/PharmaPro/alte/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="/PharmaPro/alte/dist/js/demo.js"></script>

    <!-- Page specific script -->
    <script src="/PharmaPro/alte/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script>
    $(function() {
        bsCustomFileInput.init();
    });
    </script>

    <script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "pageLength": 20,
            "buttons": ["csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "pageLength": 20,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
    </script>
    <script>
    $(function() {

        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        $('#reservationdate').datetimepicker({
            format: 'DD-MM-YYYY'
        });

        //Date and time picker
        $('#reservationdatetime').datetimepicker({
            icons: {
                time: 'far fa-clock'
            }
        });

        //Timepicker
        $('#timepicker').datetimepicker({
            format: 'HH:mm:ss'
        })

        // Summernote
        $('#du_medicine_label').summernote({
            placeholder: 'Medicine Label',
            height: 100,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'fontname']], //Specific toolbar display
                ['color', ['color']],
            ],
        });
        $('#du_description').summernote({
            placeholder: 'Description',
            height: 100,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'fontname']], //Specific toolbar display
                ['color', ['color']],
            ],
        });
    })
    </script>

    <script>
    $(document).ready(function() {
        $('#search_product').on('change', function() {
            let productId = $(this).val();

            if (productId) {
                $.ajax({
                    url: 'fetch_product_data.php', // ไฟล์ PHP ที่จะดึงข้อมูล
                    type: 'POST',
                    data: {
                        id: productId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response) {
                            $('#du_barcode').val(response.barcode);
                            // $('#du_batch_no').val(response.batch_no);
                            $('#du_genaric_name').val(response.genaric_name);
                            $('#du_brand_name').val(response.brand_name);
                            $('#du_category').val(response.category);
                            $('#du_prescription_required').val(response
                                .prescription_required);
                            $('#du_min_quantity').val(response.min_quantity);
                            $('#du_price_per_unit').val(response.price_per_unit);
                            $('#du_retail_price').val(response.retail_price);
                            $('#du_member_price').val(response.member_price);
                            $('#du_supplier_id').val(response.supplier_id);
                        } else {
                            alert('No data found for the selected product.');
                        }
                    },
                    error: function() {
                        alert('Error retrieving product data.');
                    }
                });
            } else {
                // รีเซ็ตฟอร์มหากไม่มีการเลือกสินค้า
                $('#du_barcode, #du_batch_no, #du_genaric_name, #du_brand_name').val('');
            }
        });
    });
    </script>
    <script>
    document.getElementById('saveBtn').addEventListener('click', function() {
        Swal.fire({
            title: 'ยืนยันการบันทึก?',
            text: 'คุณต้องการบันทึกข้อมูลใช่หรือไม่',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('dataform').submit(); // ค่อยส่งฟอร์ม
            }
        });
    });
    </script>

</body>

</html>