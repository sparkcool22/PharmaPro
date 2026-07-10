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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


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
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper" >
			<!-- Content Header (Page header) -->

	<?php
      if ($sACT == 'view') {
        $dataReport = $oDB->QueryRow("SELECT * FROM tbl_user_login WHERE id='" . $sID . "'", DBI_ASSOC);
        
        if ($dataReport['user_status'] =='A'){
          $dataReport['user_status'] ='Active';
        }else{
          $dataReport['user_status'] ='InActive';
        }
        
        if ($dataReport['login_date'] != null){
        $dataReport['loginuser'] = date('d-m-Y H:i:s', strtotime($dataReport['login_date']));
        }else{
        $dataReport['loginuser'] = null;
        }
      }
	?>
			<!-- Main content -->
  <section class="content pt-3 px-4" >
  <div class="container-fluid"> 
    <div class="row">
      <div class="col-12">
        <div class="card card-olive" style="background-color: #f0f0f0; color: #333;">
          <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
              <?php if ($dataReport['user_status']=='Active') {?>
              <h3 class="card-title" style="display:inline;">Staff Information</h3> <strong style="display:inline; margin-left:10px; color:white;"><?php echo $dataReport['user_status']; ?></strong> 
              <?php }else{ ?>
              <h3 class="card-title" style="display:inline;">Staff Information</h3> <strong style="display:inline; margin-left:10px; color:white;"><?php echo $dataReport['user_status']; ?></strong>
              <?php } ?>
            </div>
            <strong style="margin-left: auto;"><a  href="staff_list.php">Staff Information List</a></strong>
          </div> <!-- card-header -->

						<div class="row mt-3 mx-3">
                  <div class="col-md-8">

                    <div class="card-body">

                          <div class="row">
                            <div class="col-md-6">
                              <strong><i class="fa-solid fa-file-prescription mr-1" style='font-size:14px'></i> User Name</strong> <small>(ชื่อผู้ใช้)</small>
                                <p class="text-muted pl-4">
                                <?php if ($dataReport['user']) { ?>
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <?php echo base64_decode(isset($dataReport['user']) ? $dataReport['user'] : ''); ?>
                                <?php }else{ ?>
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <span style="font-style: italic; opacity: 0.5;">No Information</span>
                                <?php } ?>
                                </p>
                                <hr>
                            </div>
                            <div class="col-md-6">
                              <strong><i class="fa-solid fa-file-prescription mr-1" style='font-size:14px'></i> Name</strong> <small>(ชื่อ สกุล)</small>
                                <p class="text-muted pl-4">
                                <?php if ($dataReport['full_name']) { ?>
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <?php echo $dataReport['full_name'] ?>
                                <?php }else{ ?>
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <span style="font-style: italic; opacity: 0.5;">No Information</span>
                                <?php } ?>
                                </p>
                                <hr>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-12">
                              <strong><i class="fa-solid fa-file-prescription mr-1" style='font-size:14px'></i> Address</strong> <small>(ที่อยู่)</small>
                                <p class="text-muted pl-4">
                                <?php if ($dataReport['address']) { ?>
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <?php echo $dataReport['address'] ?>
                                <?php }else{ ?>
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <span style="font-style: italic; opacity: 0.5;">No Information</span>
                                <?php } ?>
                                </p>
                                <hr>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <strong><i class="fa-solid fa-file-prescription mr-1" style='font-size:14px'></i> Phone</strong> <small>(โทรศัพท์)</small>
                                <p class="text-muted pl-4">
                                <?php if ($dataReport['phone']) { ?>
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <?php echo $dataReport['phone'] ?>
                                <?php }else{ ?>
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <span style="font-style: italic; opacity: 0.5;">No Information</span>
                                <?php } ?>
                                </p>
                                <hr>
                            </div>
                            <div class="col-md-6">
                              <strong><i class="fa-solid fa-file-prescription mr-1" style='font-size:14px'></i> Email</strong> <small>(อีเมล)</small>
                                <p class="text-muted pl-4">
                                <?php if ($dataReport['email']) { ?>
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <?php echo $dataReport['email'] ?>
                                <?php }else{ ?>
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <span style="font-style: italic; opacity: 0.5;">No Information</span>
                                <?php } ?>
                                </p>
                                <hr>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">                           
                                <?php if ($dataReport['user_status']=='Active') { ?>  
                                <strong><i class="fa-solid fa-file-prescription mr-1" style='font-size:14px'></i> Status</strong> <small>(สถานะ)</small><i class="fa-solid fa-circle fa-beat ml-2" style="color: green;"></i>
                                <p class="text-muted pl-4">
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <?php echo $dataReport['user_status'] ?>
                                <?php }else{ ?>
                                <strong><i class="fa-solid fa-file-prescription mr-1" style='font-size:14px'></i> Status</strong> <small>(สถานะ)</small><i class="fa-solid fa-circle fa-beat ml-2" style="color: red;"></i>
                                <p class="text-muted pl-4">
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <?php echo $dataReport['user_status'] ?>
                                <?php } ?>
                                </p>
                                <hr>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-12">
                              <strong><i class="fa-solid fa-file-prescription mr-1" style='font-size:14px'></i> Login Date/Time</strong> <small>(วัน/เวลา ที่ล๊อกอิน)</small>
                                <p class="text-muted pl-4">
                                <?php if ($dataReport['loginuser']) { ?>
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <?php echo $dataReport['loginuser'] ?>
                                <?php }else{ ?>
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <span style="font-style: italic; opacity: 0.5;">No Information</span>
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
                            <strong><i class="fa-solid fa-file-prescription mr-1" style='font-size:14px'></i> Picture</strong> <small>(รูปภาพพนักงาน)</small>
                              <p class="text-muted px-4 py-2">
                              <?php if ($dataReport["picture"] != '') { ?>
                                    <img src=<?php echo "../upload/user_images/" . $dataReport['picture'] ?> class="img-fluid img-thumbnail" style="width: auto; height: 300px;"  alt="Photo" />
                                  <?php } else { ?>
                                    <img src="../upload/user_images/img_not.gif" class="img-fluid" alt="Photo">
                                  <?php } ?>
                              </p>
                          </div>
                        </div>
                    </div> <!-- card-body  -->

                  </div> <!-- col 4 -->
            </div> <!-- row class="row mt-3 mx-3"-->
        </div> <!-- card card-info -->
      </div> <!-- col 12 -->
    </div> <!-- row -->
  </div> <!-- container-fluid  -->
</section>


			<!-- ---Main content -->
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


</body>
</html>
