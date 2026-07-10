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
$sUID = isset($_REQUEST['puid']) ? $_REQUEST['puid'] : '';
$sID =  isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
$sGID = isset($_REQUEST['gid']) ? $_REQUEST['gid'] : '';
$sDATAX = isset($_REQUEST['datax']) ? $_REQUEST['datax'] : '';
$sAUXID = isset($_REQUEST['auxid']) ? $_REQUEST['auxid'] : '';

if ($sUserID) {
  $dataUserinfo = $oDB->QueryRow("SELECT * FROM tbl_user_login WHERE id='" . $sUserID . "'", DBI_ASSOC);
  $dataUserinfo['pic_url'] = USERIMG_URL . $dataUserinfo['picture'];
}
if ($sUID) {
  $dataStaff = $oDB->QueryRow("SELECT * FROM tbl_user_login WHERE id='" . $sUID . "'", DBI_ASSOC);
  $dataStaff['pic_url'] = USERIMG_URL . $dataUserinfo['picture'];
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
  <?php //include("l_head_content.php"); ?>

    <!-- Main content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12 mt-2">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Staff Authentication List</h3>
                  <div class=" float-sm-right">
                    <a class="btn btn-block btn-success btn-sm" href="authen_form.php?act=new"><i class="fas fa-plus-circle"></i> Create Authentication</a>
                  </div>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                <thead>
                      <tr>
                        <th>No</th>
                        <th>Permission</th>
                        <th>Detail</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($sACT=='set') {
                      $sSql1 = "UPDATE tbl_authen SET  au_status= '".$sStatus."' WHERE au_id='".$sID."'";
                      $oDB->Execute($sSql1);

                    }					  

                    $axSql= $oDB->Query("SELECT * FROM tbl_authen  ORDER BY au_status ASC, au_id ASC");
                              $rownum= 1;			
                              while ($asResult = $axSql->FetchRow(DBI_ASSOC)) { ?>

                              <tr 
                              <?php if ($asResult["au_status"]=='N'){?>
                                style="font-style: italic;text-decoration: underline; color: darkgray;";
                              <?php } ?> 
                              >
                                <td><?php echo $rownum;?></td>
                                <td><?php echo $asResult["au_name"];?></td>
                                <td><?php echo $asResult["au_detail"];?></td>   
                                <td>
                                <?php if ($asResult["au_status"]=='A') { ?>
                                <a href="?act=set&status=N&id=<?php echo $asResult["au_id"];?>"><span class="badge badge-pill badge-success"><i class="fas fa-check-circle">
                                                  </i>
                                                  Active
                                </span>
                                </a>
                                <?php }else{ ?>
                                <a href="?act=set&status=A&id=<?php echo $asResult["au_id"];?>"><span class="badge badge-pill badge-danger"><i class="far fa-times-circle">
                                                  </i>
                                                  InActive
                                </span>
                                </a>	
                              <?php } ?>
                                        
                                        </td>                 
                                  <?php $rownum = $rownum+1; ?>
                                      </tr>
                              <?php } ?>
                    </tbody>
                    <tfoot>
                      <tr>
                      <th>No</th>
                        <th>Permission</th>
                        <th>Detail</th>
                        <th>Status</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->

              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section> <!-- /.content -->
    </div>
    <!-- /.content -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <?php include("l_footer.php"); ?>
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
  <!-- Page specific script -->

  <script>
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "pageLength": 20,
        "paging": true
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
  
</body>
</html>
