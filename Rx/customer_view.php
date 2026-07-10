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
        $dataReport = $oDB->QueryRow("SELECT * FROM tbl_customer WHERE id='" . $sID . "'", DBI_ASSOC);
                
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

        $dataReport['createuser'] = $oDB->QueryOne("SELECT full_name FROM tbl_product n1 INNER JOIN tbl_user_login n2 WHERE n1.user_insert = n2.id AND n1.id='" . $sID . "' ");
        $dataReport['createuser'] = $dataReport['createuser']." ".date('d-m-Y H:i:s', strtotime($dataReport['insert_date']));
        $dataReport['updateuser'] = $oDB->QueryOne("SELECT full_name FROM tbl_product n1 INNER JOIN tbl_user_login n2 WHERE n1.user_update = n2.id AND n1.id='" . $sID . "' ");
        $dataReport['updateuser'] = $dataReport['updateuser']." ".date('d-m-Y H:i:s', strtotime($dataReport['update_date']));
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
              <?php if ($dataReport['approve_status']=='Active') {?>
              <h3 class="card-title" style="display:inline;">Customer Information</h3> <strong style="display:inline; margin-left:10px; color:white;"><?php echo $dataReport['approve_status']; ?></strong> 
              <?php }else{ ?>
              <h3 class="card-title" style="display:inline;">Customer Information</h3> <strong style="display:inline; margin-left:10px; color:white;"><?php echo $dataReport['approve_status']; ?></strong>
              <?php } ?>
            </div>
            <strong style="margin-left: auto;"><a  href="customer_list.php">Customer Information List</a></strong>
          </div> <!-- card-header -->

						<div class="row mt-3 mx-3">
                  <div class="col-md-6">

                    <div class="card-body">

                          <div class="row">
                            <div class="col-md-12">
                              <strong><i class="fa-solid fa-file-prescription mr-1" style='font-size:14px'></i> Name</strong> <small>(ชื่อลูกค้า)</small>
                                <p class="text-muted pl-4">
                                <?php if ($dataReport['customer_name']) { ?>
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <?php echo $dataReport['customer_name'] ?>
                                <?php }else{ ?>
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <span style="font-style: italic; opacity: 0.5;">No Information</span>
                                <?php } ?>
                                </p>
                                <hr>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-12">
                              <strong><i class="fa-solid fa-file-prescription mr-1" style='font-size:14px'></i> Address</strong> <small>(ที่อยู่ลูกค้า)</small>
                                <p class="text-muted pl-4">
                                <?php if ($dataReport['customer_address']) { ?>
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <?php echo $dataReport['customer_address'] ?>
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
                                <?php if ($dataReport['customer_phone']) { ?>
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <?php echo $dataReport['customer_phone'] ?>
                                <?php }else{ ?>
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <span style="font-style: italic; opacity: 0.5;">No Information</span>
                                <?php } ?>
                                </p>
                                <hr>
                            </div>
                            <div class="col-md-6">
                              <strong><i class="fa-solid fa-file-prescription mr-1" style='font-size:14px'></i> Email</strong> <small>(อีเมล)</small>
                                <p class="text-muted pl-4">
                                <?php if ($dataReport['customer_email']) { ?>
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <?php echo $dataReport['customer_email'] ?>
                                <?php }else{ ?>
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <span style="font-style: italic; opacity: 0.5;">No Information</span>
                                <?php } ?>
                                </p>
                                <hr>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-12">
                              <strong><i class="fa-solid fa-file-prescription mr-1" style='font-size:14px'></i> Remark</strong> <small>(หมายเหตุ)</small>
                                <p class="text-muted pl-4">
                                <?php if ($dataReport['customer_remark']) { ?>
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <?php echo $dataReport['customer_remark'] ?>
                                <?php }else{ ?>
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <span style="font-style: italic; opacity: 0.5;">No Information</span>
                                <?php } ?>
                                </p>
                                <hr>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">                           
                            <strong><i class="fa-solid fa-file-prescription mr-1" style='font-size:14px'></i> Member</strong> <small>(สมาชิก)</small>
                                <p class="text-muted pl-4">
                                <?php if ($dataReport['member']) { ?>
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <?php echo $dataReport['member'] ?>
                                <?php }else{ ?>
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <span style="font-style: italic; opacity: 0.5;">No Information</span>
                                <?php } ?>
                                </p>
                                <hr>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">                           
                                <?php if ($dataReport['approve_status']=='Active') { ?>  
                                <strong><i class="fa-solid fa-file-prescription mr-1" style='font-size:14px'></i> Status</strong> <small>(สถานะ)</small><i class="fa-solid fa-circle fa-beat ml-2" style="color: green;"></i>
                                <p class="text-muted pl-4">
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <?php echo $dataReport['approve_status'] ?>
                                <?php }else{ ?>
                                <strong><i class="fa-solid fa-file-prescription mr-1" style='font-size:14px'></i> Status</strong> <small>(สถานะ)</small><i class="fa-solid fa-circle fa-beat ml-2" style="color: red;"></i>
                                <p class="text-muted pl-4">
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <?php echo $dataReport['approve_status'] ?>
                                <?php } ?>
                                </p>
                                <hr>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <strong><i class="fa-solid fa-file-prescription mr-1" style='font-size:14px'></i> User Create</strong> <small>(ผู้นำเข้าข้อมูล)</small>
                                <p class="text-muted pl-4">
                                <?php if ($dataReport['user_insert']) { ?>
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <?php echo $dataReport['createuser'] ?>
                                <?php }else{ ?>
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <span style="font-style: italic; opacity: 0.5;">No Information</span>
                                <?php } ?>
                                </p>
                                <hr>
                            </div>
                            <div class="col-md-6">
                              <strong><i class="fa-solid fa-file-prescription mr-1" style='font-size:14px'></i> User Update</strong> <small>(ผู้อัพเดดข้อมูล)</small>
                                <p class="text-muted pl-4">
                                <?php if ($dataReport['user_update']) { ?>
                                <i class="fa-solid fa-capsules mr-1" style='font-size:10px'></i> <?php echo $dataReport['updateuser'] ?>
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
