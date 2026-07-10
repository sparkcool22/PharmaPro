<?php
include("../../include/config.php");
include("../../include/common.php");

CheckUserLogin_Backend();

$sUserID = isset($_SESSION['au_member_id']) ? $_SESSION['au_member_id'] : '';
$sACT =  isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
$sID =  isset($_REQUEST['id']) ? $_REQUEST['id'] : '';

$oDB = new DBI();

if ($sUserID) {
	$dataUserinfo = $oDB->QueryRow("SELECT * FROM tbl_user_login WHERE id='" . $sUserID . "'", DBI_ASSOC);
	$dataUserinfo['pic_url'] = USERIMG_URL . $dataUserinfo['picture'];
}

$axSql_team = $oDB->Query("SELECT * FROM tbl_team");
while ($asResult = $axSql_team->FetchRow(DBI_ASSOC)) {
	$asTeam[] = $asResult;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Inventory Control</title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="/PharmaPro/alte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="/PharmaPro/alte/plugins/fontawesome-free/css/all.css">
	<link rel="stylesheet" href="/PharmaPro/alte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="/PharmaPro/alte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="/PharmaPro/alte/dist/css/adminlte.min.css">

	<script type="text/JavaScript">
		function chkPass(){
  var s = document.dataform;

  if(s.password_master.value != s.password_confirm.value){ 
	alert("Password mismatch Please confirm your password again");
	return false;
  }
}
</script>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
	<!-- Site wrapper -->
	<div class="wrapper">
		<!-- Navbar -->
		<?php include("../admin/l_head_m1.php");  ?>

		<!-- /.navbar -->

		<!-- Main Sidebar Container -->
		<?php include("../admin/l_menu.php");  ?>

		<?php
		if ($sACT == 'new') {
			$action = 'add';
		} elseif ($sACT == 'add') {
			// $_POST['du_insert_date'] =  'SYSDATE()';
			$_POST['du_user'] = base64_encode($_POST['du_user']);
			$_POST['du_pass'] = base64_encode($_POST['password_master']);
			$_POST['du_email'] = strtolower($_POST['du_email']);

			//$sql = "SELECT * FROM tbl_user_login WHERE email = '".$_POST['du_email']."' AND approve_status ='A' ";
			$axSql_email = $oDB->QueryRow("SELECT * FROM tbl_user_login WHERE email = '" . $_POST['du_email'] . "' AND approve_status ='A'", DBI_ASSOC);
			if ($axSql_email) {
				echo "<script>alert('ไม่สามารถเพิ่มข้อมูลได้เนื่องจากมี Email นี้ในระบบแล้ว');</script>";
				Redirect('user_form.php?act=new');
				exit();
			}

			// upload picture
			$upload = $_FILES['picture']['name'];
			if ($upload <> '') {   //not select file
				//โฟลเดอร์ที่จะ upload file เข้าไป 
				$path = "../../upload/user_images/";

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

			$inSql = "INSERT INTO tbl_user_login (" . $sField . ") VALUES (" . $sValue . ")";
			$oDB->Execute($inSql);
			if ($inSql) {
				Redirect('user_list.php');
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
			$axSql = $oDB->Query("SELECT * FROM tbl_user_login WHERE id='" . $sID . "' ");
			//$query = mysqli_query($con, $sql);
			while ($asResult = $axSql->FetchRow(DBI_ASSOC)) {

				$asData = $asResult;
			}

			$action = 'update';
		} elseif ($sACT == 'update') {

			// $_POST['du_update_date'] = 'SYSDATE()';
			$_POST['du_pass'] = base64_encode($_POST['password_master']);
			$_POST['du_user'] = base64_encode($_POST['du_user']);
			$_POST['du_email'] = strtolower($_POST['du_email']);

			if (!$_POST['du_team_id']){
				$_POST['du_team_id'] = '0' ;			
			}

			//$_POST['email'] 

			// $pe_email = mysqli_fetch_array(mysqli_query($con, "SELECT *  FROM tbl_user_login WHERE id= $sID AND approve_status ='A' ",MYSQLI_ASSOC));
			$pe_email = $oDB->QueryRow("SELECT *  FROM tbl_user_login WHERE id= $sID ", DBI_ASSOC);

			if ($pe_email['email'] != $_POST['du_email']) {
				// $sql = "SELECT * FROM tbl_user_login WHERE email = '".$_POST['du_email']."' AND approve_status ='A' ";
				$sql_email = $oDB->QueryRow("SELECT *  FROM tbl_user_login WHERE id= '" . $sID . "' ", DBI_ASSOC);

				if ($sql_email) {
					echo "<script>alert('ไม่สามารถแก้ไขข้อมูลได้เนื่องจากมี Email นี้ในระบบแล้ว');</script>";
					Redirect('user_form.php?act=new');
					exit();
				}
			}

			// upload picture

			$upload = $_FILES['picture']['name'];
			if ($upload <> '') {   //not select file
				//โฟลเดอร์ที่จะ upload file เข้าไป 
				$path = "../../upload/user_images/";

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
			$upSql = "UPDATE tbl_user_login SET " . $sSetDataUpdate . " WHERE id='" . $sID . "'";
			$oDB->Execute($upSql);
			if ($upSql) {

				Redirect('user_form.php?act=edit&id=' . $sID);
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
			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-12">
							<div class="card card-primary">
								<div class="card-header">
									<h3 class="card-title">Create / edit Member Form</h3>
								</div>
								<!-- /.card-header -->
								<!-- form start -->
								<form name="dataform" id="dataform" action="" method="post" enctype="multipart/form-data">

									<div class="row">

										<!--First Half-->
										<div class="card-body">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>User Name</label>
														<?php if ($sACT == 'new') { ?>
															<input type="text" name="du_user" id="du_user" value="<?php echo base64_decode(isset($asData['user']) ? $asData['user'] : ''); ?>" class="form-control" placeholder="User ..." required>
														<?php } else { ?>
															<input type="text" name="du_user" id="du_user" value="<?php echo base64_decode(isset($asData['user']) ? $asData['user'] : ''); ?>" class="form-control" placeholder="User ..." required readonly>
														<?php } ?>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-3">
													<div class="form-group">
														<label>Password</label>
														<input type="password" name="password_master" id="password_master" class="form-control" placeholder="Password ...">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label>Confirm Password</label>
														<input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Confirm Password ...">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-3">
													<div class="form-group">
														<label>Email</label>
														<?php if ($sACT == 'new') { ?>
															<input type="email" name="du_email" id="du_email" <?php echo $d_email ?> value="<?php echo isset($asData['email']) ? $asData['email'] : ''; ?>" class="form-control" placeholder="Email..." required>
														<?php } else { ?>
															<input type="email" name="du_email" id="du_email" <?php echo $d_email ?> value="<?php echo isset($asData['email']) ? $asData['email'] : ''; ?>" class="form-control" placeholder="Email..." required readonly>
														<?php } ?>
													</div>
												</div>
												<div class="col-md-1">
													<div class="form-group">
														<label>Employee ID</label>
														<input type="text" name="du_employee_id" id="du_employee_id" value="<?php echo isset($asData['employee_id']) ? $asData['employee_id'] : ''; ?>" class="form-control" placeholder="Employee ID..." required>
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<label>Team</label>
														<select class="form-control" name="du_team_id" id="du_team_id">
															<option value="">Team Center</option>
															<?php foreach ($asTeam as $asTeam) { ?>
																<?php if ($asData['team_id'] == $asTeam['id']) { ?>
																	<option value="<?php echo $asTeam['id'] ?>" selected><?php echo $asTeam['team_name'] ?></option>
																<?php } else { ?>
																	<option value="<?php echo $asTeam['id'] ?>"><?php echo $asTeam['team_name'] ?></option>
																<?php } ?>
															<?php } ?>
														</select>
														<!-- <input type="text" name="du_employee_id" id="du_employee_id" value="<?php echo isset($asData['employee_id']) ? $asData['employee_id'] : ''; ?>" class="form-control" placeholder="Employee ID..." required> -->
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-3">
													<div class="form-group">
														<label>Name</label>
														<input type="text" name="du_firstname" id="du_firstname" value="<?php echo isset($asData['firstname']) ? $asData['firstname'] : ''; ?>" class="form-control" placeholder="Name ..." required>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label>Surname</label>
														<input type="text" name="du_lastname" id="du_lastname" value="<?php echo isset($asData['lastname']) ? $asData['lastname'] : ''; ?>" class="form-control" placeholder="Surname ..." required>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-3">
													<div class="form-group">
														<label>Positions</label>
														<input type="text" name="du_position" id="du_position" value="<?php echo isset($asData['position']) ? $asData['position'] : ''; ?>" class="form-control" placeholder="Position ...">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label>Department</label>
														<input type="text" name="du_department" id="du_department" value="<?php echo isset($asData['department']) ? $asData['department'] : ''; ?>" class="form-control" placeholder="Department ..." required>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-2">
													<div class="form-group">
														<label>User Level</label>
														<select name="du_user_level" id="du_user_level" class="form-control">
															<?php
															foreach ($asUserLevel as $key => $value) :
																if ($key == $asData['user_level']) {
																	echo '<option selected=selected value= "' . $key . '">' . $value . '</option>'; //close your tags!!
																} else {
																	echo '<option value="' . $key . '">' . $value . '</option>'; //close your tags!!	
																}
															endforeach;
															?>
														</select>
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<label>User Status</label>
														<select name="du_user_status" id="du_user_status" class="form-control">
															<?php
															foreach ($asStatus as $key => $value) :
																if ($key == $asData['user_status']) {
																	echo '<option selected=selected value= "' . $key . '">' . $value . '</option>'; //close your tags!!
																} else {
																	echo '<option value="' . $key . '">' . $value . '</option>'; //close your tags!!	
																}
															endforeach;
															?>
														</select>
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group">
														<label>Confirm Status</label>
														<select name="du_confirm_status" id="du_confirm_status" class="form-control">
															<?php
															foreach ($asStatus as $key => $value) :
																if ($key == $asData['confirm_status']) {
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
												<div class="col-md-5">
													<div class="card-body">
														<div class="form-group">
															<?php if ($asData["picture"] != '') { ?>
																<img src=<?php echo "../../upload/user_images/" . $asData['picture'] ?> class="img-fluid" alt="Photo" />
															<?php } else { ?>
																<img src="../../upload/user_images/img_not.gif" class="img-fluid" alt="Photo">
															<?php } ?>
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
											</div>
										</div>

										<!--Second Half-->
									</div> <!--Div Row-->

									<div class="card-footer">
										<button type="submit" class="btn btn-primary" value="save" onClick="return chkPass();">Save</button>
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

		<?php include("../admin/l_footer.php");  ?>

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->
	</div>
	<!-- ./wrapper -->

	<!-- jQuery -->
	<!-- jQuery -->
	<script src="/PharmaPro/alte/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="/PharmaPro/alte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- DataTables  & Plugins -->
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
</body>

</html>