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

  <script type="text/JavaScript">
	function chkPass(){
		var form = document.getElementById('dataform');
		if (form.password_master.value != form.password_confirm.value) { 
			alert("Password mismatch. Please confirm your password again.");
			return false;
		}
		return true;
	}
</script>
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

			$inSql = "INSERT INTO tbl_authen (" . $sField . ") VALUES (" . $sValue . ")";
			$oDB->Execute($inSql);
			if ($inSql) {
				Redirect('staff_authen.php');
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
			$axSql = $oDB->Query("SELECT * FROM tbl_authen WHERE id='" . $sID . "' ");
			while ($asResult = $axSql->FetchRow(DBI_ASSOC)) {

				$asData = $asResult;
			}

			$action = 'update';
		} elseif ($sACT == 'update') {

			$_POST['du_update_date'] = 'SYSDATE()';

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
			$upSql = "UPDATE tbl_authen SET " . $sSetDataUpdate . " WHERE id='" . $sID . "'";
			$oDB->Execute($upSql);
			if ($upSql) {

				Redirect('authen_list.php');
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
			<form name="dataform" id="dataform" action="" method="post" enctype="multipart/form-data">
				<div class="card card-info">
						<div class="card-header">
							<h3 class="card-title">Create/Edit Staff Form</h3>
						</div> 
					<div class="col-sm-12">
					<div class="row mt-3 mx-3">


						<!-- first -->
						<div class="col-sm-9">

						<div class="row">
							<div class="col-md-8">
								<div class="form-group">
									<label>Authentication Name</label>
									<input type="text" name="du_au_name" id="du_au_name" value="<?php echo isset($asData['au_name']) ? $asData['au_name'] : ''; ?>" class="form-control" placeholder="Authentication Name ..." required>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Authentication Detail</label>
									<input type="text" name="du_au_detail" id="du_au_detail" value="<?php echo isset($asData['au_detail']) ? $asData['au_detail'] : ''; ?>" class="form-control" placeholder="Authentication Detail ..." >
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Status</label>
									<select name="du_au_status" id="du_au_status" class="form-control">
										<?php
										foreach ($asStatus as $key => $value) :
											if ($key == $asData['au_status']) {
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
 
						<!-- second -->
						<div class="col-sm-3">
						<div class="row">

						<!-- second content-->
						
						</div>
						</div>

					</div> <!-- row -->
					</div> <!-- col-sm-12 -->
						<!-- third -->
						<div class="card-footer">
						<button type="submit" class="btn btn-success btn-block" value="save" onClick="return chkPass();">Save</button>
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
