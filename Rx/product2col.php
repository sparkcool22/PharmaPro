<?php
include '../include/config.php';
include '../include/common.php';

// Read parameters
$sACT = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';

$oDB = new DBI();
$oTmp = new TemplateEngine();
$oLogin = new LoginManager();


$sUserID = isset($_SESSION['aupro_member_id']) ? $_SESSION['aupro_member_id'] : '';
$sACT = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';

$sStatus = isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
$sID = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';

if ($sUserID) {
    $dataUserinfo = $oDB->QueryRow("SELECT * FROM tbl_user_login WHERE id='" . $sUserID . "'", DBI_ASSOC);
    $dataUserinfo['pic_url'] = USERIMG_URL . $dataUserinfo['picture'];
}

$axSql_Drug_Category = $oDB->Query("SELECT * FROM tbl_drug_category");
while ($asResult = $axSql_Drug_Category->FetchRow(DBI_ASSOC)) {
  $asDrugCategory[] = $asResult;
}

$axSql_Supplier = $oDB->Query("SELECT * FROM tbl_supplier");
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
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/PharmaPro/alte/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/PharmaPro/alte/dist/css/adminlte.min.css">


    <!-- Theme style -->
  <link rel="stylesheet" href="/PharmaPro/alte/plugins/daterangepicker/daterangepicker.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="/PharmaPro/alte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Theme style -->

  <link rel="stylesheet" href="/PharmaPro/alte/plugins/summernote/summernote-bs4.min.css">

  <link rel="stylesheet" href="../public/customCSS/custom_css.css">

  <script src="/PharmaPro/alte/plugins/jquery/jquery.min.js"></script>

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
				Redirect('product_list.php');
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
			$oDB->Execute($upSql);
			if ($upSql) {

				Redirect('product_list.php');
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
<div class="content-wrapper" >
			<!-- Content Header (Page header) -->

			<!-- Main content -->
<section class="content pt-3 px-4" >
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">

				<div class="card card-info">
						<div class="card-header">
							<h3 class="card-title">Create/Edit Drug Info Form</h3>
						</div> 
						<div class="row mt-3 mx-3">

							<!-- first -->
							<div class="col-sm-6">

								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Barcode  <small>(บาร์โค้ด)</small></label>
											<input type="text" name="du_barcode" id="du_barcode" value="<?php echo isset($asData['barcode']) ? $asData['barcode'] : ''; ?>" class="form-control" placeholder="Barcode ...">
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
											<label>Barcode  <small>(บาร์โค้ด)</small></label>
											<input type="text" name="du_barcode" id="du_barcode" value="<?php echo isset($asData['barcode']) ? $asData['barcode'] : ''; ?>" class="form-control" placeholder="Barcode ...">
										</div>
									</div>
								</div>					

							</div>
							<!-- second -->


						</div> <!-- row -->
						<!-- third -->
							<div class="card-footer">
								<button type="submit" class="btn btn-success btn-block" value="save" onClick="return chkPass();">Save</button>
									<input name="du_id" type="hidden" id="du_id" value="1" />
								<input name="act" type="hidden" id="act" value="" />
							</div>
				</div> <!-- card card-info -->
				
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
	

	$('#reservationdate').datetimepicker({
	format: 'YYYY-MM-DD'
	});

    //Date and time picker
    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });
		
    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'HH:mm:ss'
    })
	
	// Summernote
	$('#du_medicine_label').summernote({
		placeholder: 'Medicine Label',
		toolbar: [
			['style', ['bold', 'italic', 'underline', 'fontname']], //Specific toolbar display
			['color', ['color']],
		],
	});
	$('#du_description').summernote({
		placeholder: 'Description',
		toolbar: [
			['style', ['bold', 'italic', 'underline', 'fontname']], //Specific toolbar display
			['color', ['color']],
		],
	});
})
</script>

</body>
</html>
