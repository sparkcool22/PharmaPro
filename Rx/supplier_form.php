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

  <!--Style ตาราง -->
  <link rel="stylesheet" href="/PharmaPro/alte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="/PharmaPro/alte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="/PharmaPro/alte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

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
			$_POST['du_insert_date'] =  'SYSDATE()';

			// // upload picture
			// $upload = $_FILES['picture']['name'];
			// if ($upload <> '') {   //not select file
			// 	//โฟลเดอร์ที่จะ upload file เข้าไป 
			// 	$path = "../../upload/user_images/";

			// 	//เอาชื่อไฟล์เก่าออกให้เหลือแต่นามสกุล
			// 	$type = strrchr($_FILES['picture']['name'], ".");

			// 	//ตั้งชื่อไฟล์ใหม่โดยเอาเวลาไว้หน้าชื่อไฟล์เดิม
			// 	$newname = date('ymdHis') . $numrand . $type;
			// 	$path_copy = $path . $newname;
			// 	//$path_link="fileupload/".$newname;
			// 	move_uploaded_file($_FILES['picture']['tmp_name'], $path_copy);
			// 	$_POST['du_picture'] = $newname;
			// }

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

			$inSql = "INSERT INTO tbl_supplier (" . $sField . ") VALUES (" . $sValue . ")";
			$oDB->Execute($inSql);
			if ($inSql) {
				Redirect('supplier_list.php');
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
			// $sql = "SELECT * FROM tbl_user_login WHERE id=" .$sID or die("Error:" . mysqli_error());
			$axSql = $oDB->Query("SELECT * FROM tbl_supplier WHERE id='" . $sID . "' ");
			//$query = mysqli_query($con, $sql);
			while ($asResult = $axSql->FetchRow(DBI_ASSOC)) {

				$asData = $asResult;
			}

			$action = 'update';
		} elseif ($sACT == 'update') {

			$_POST['du_update_date'] = 'SYSDATE()';

			// upload picture

			// $upload = $_FILES['picture']['name'];
			// if ($upload <> '') {   //not select file
			// 	//โฟลเดอร์ที่จะ upload file เข้าไป 
			// 	$path = "../../upload/user_images/";

			// 	//เอาชื่อไฟล์เก่าออกให้เหลือแต่นามสกุล
			// 	$type = strrchr($_FILES['picture']['name'], ".");

			// 	//ตั้งชื่อไฟล์ใหม่โดยเอาเวลาไว้หน้าชื่อไฟล์เดิม
			// 	$newname = date('ymdHis') . $numrand . $type;
			// 	$path_copy = $path . $newname;
			// 	//$path_link="fileupload/".$newname;
			// 	move_uploaded_file($_FILES['picture']['tmp_name'], $path_copy);
			// 	$_POST['du_picture'] = $newname;
			// }

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
			$upSql = "UPDATE tbl_supplier SET " . $sSetDataUpdate . " WHERE id='" . $sID . "'";
			$oDB->Execute($upSql);
			if ($upSql) {

				Redirect('supplier_list.php');
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
									<h3 class="card-title">Create/Edit Supplier Form</h3>
								</div>
								<!-- /.card-header -->
								<!-- form start -->
								<form name="dataform" id="dataform" action="" method="post" enctype="multipart/form-data">

									<div class="row">

										<!--First Half-->
										<div class="card-body mx-3">

											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Name</label>
														<input type="text" name="du_supplier_name" id="du_supplier_name" value="<?php echo isset($asData['supplier_name']) ? $asData['supplier_name'] : ''; ?>" class="form-control" placeholder="Supplier Name ..." required>
													</div>
												</div>
											</div>
											<div class="row">
                      							<div class="col-md-6">
													<div class="form-group">
														<label>Address</label>
														<input type="text" name="du_supplier_address" id="du_supplier_address" value="<?php echo isset($asData['supplier_address']) ? $asData['supplier_address'] : ''; ?>" class="form-control" placeholder="Supplier Address ..." required>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-3">
													<div class="form-group">
														<label>Phone</label>
														<input type="text" name="du_supplier_phone" id="du_supplier_phone" value="<?php echo isset($asData['supplier_phone']) ? $asData['supplier_phone'] : ''; ?>" class="form-control" placeholder="Supplier Phone ..." required>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label>Email</label>
														<input type="text" name="du_supplier_email" id="du_supplier_email" value="<?php echo isset($asData['supplier_email']) ? $asData['supplier_email'] : ''; ?>" class="form-control" placeholder="Supplier Email ..." required>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Remark</label>
													<textarea name="du_supplier_remark" id="du_supplier_remark"><?php echo isset($asData['supplier_remark']) ? $asData['supplier_remark'] : ''; ?></textarea>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-2">
													<div class="form-group">
														<label>Status</label>
														<select name="du_approve_status" id="du_approve_status" class="form-control">
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

											<!-- <div class="row">
												<div class="col-md-5">
													<div class="card-body">
														<div class="form-group">
															<?php //if ($asData["picture"] != '') { ?>
																<img src=<?php //echo "../../upload/user_images/" . $asData['picture'] ?> class="img-fluid" alt="Photo" />
															<?php //} else { ?>
																<img src="../../upload/user_images/img_not.gif" class="img-fluid" alt="Photo">
															<?php //} ?>
														</div>

														<div class="form-group">
															<div class="col-md-10">
																<div class="custom-file">
																	<input type="file" class="custom-file-input" id="picture" name="picture">
																	<label class="custom-file-label" for="customFile">Choose file</label>
																</div>
															</div>
														</div>

													</div>
												</div>
											</div> -->

										</div>

										<!--Second Half-->
									</div> <!--Div Row-->

									<div class="card-footer">
										<button type="submit" class="btn btn-success btn-block" value="save">Save</button>
										<?php if ($action != 'add') { ?>
											<input name="du_id" type="hidden" id="du_id" value="1" />
										<?php } ?>
										<input name="act" type="hidden" id="act" value="<?php echo $action ?>" />
									</div>

								</form>
							</div>
						</div>
					</div>
				</div>

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
    <script src="/PharmaPro/alte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="/PharmaPro/alte/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="/PharmaPro/alte/dist/js/demo.js"></script>

  <!-- Script ตาราง -->
  <!-- <script src="/PharmaPro/alte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script> -->
  <script src="/PharmaPro/alte/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="/PharmaPro/alte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="/PharmaPro/alte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="/PharmaPro/alte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="/PharmaPro/alte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="/PharmaPro/alte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="/PharmaPro/alte/plugins/jszip/jszip.min.js"></script>
  <script src="/PharmaPro/alte/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="/PharmaPro/alte/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="/PharmaPro/alte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="/PharmaPro/alte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="/PharmaPro/alte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <script src="/PharmaPro/alte/plugins/summernote/summernote-bs4.min.js"></script>
  <!-- Page specific script -->

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
          // Summernote
          $('#du_supplier_remark').summernote({
              placeholder: 'Supplier Remark',
              toolbar: [
                  ['style', ['bold', 'italic', 'underline', 'fontname']], //Specific toolbar display
                  ['color', ['color']],
              ],
          });
      })
  </script>

</body>
</html>
