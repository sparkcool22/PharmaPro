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
// $sACT = 'edit';

$sStatus = isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
$sMemberStatus = isset($_REQUEST['memberstatus']) ? $_REQUEST['memberstatus'] : '';
$sID = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
$eID = isset($_REQUEST['eid']) ? $_REQUEST['eid'] : '';

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

  <link rel="stylesheet" href="../public/customCSS/custom_css.css">

  <script src="/PharmaPro/alte/plugins/jquery/jquery.min.js"></script>
  <style>
    #example1_wrapper .dataTables_length {
        margin-left: 15px; /* เพิ่มระยะห่างระหว่าง Show กับ Search */
    }  
    .order-s1 {
    order: 1;
    }
    .order-s2 {
        order: 2;
    }

  </style>
  
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
                  <h3 class="card-title">Inventory Adjustment List</h3>
                  <div class=" float-sm-right">
                    <!-- <a class="btn btn-block btn-success btn-sm" href="customer_form.php?act=new"><i class="fas fa-plus-circle"></i> Create Customer</a> -->
                  </div>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                <thead>
                      <tr>
                        <th>No</th>
                        <th>ชื่อยา</th>
                        <th>จำนวน</th>
                        <th>ราคาต่อหน่วย</th>
                        <th>ราคารวม</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if ($sACT == 'inactive') {
                        $sSql1 = "UPDATE tbl_inventory_adjustment_items SET  approve_status= '" . $sStatus . "' WHERE id='" . $eID . "'";
                        $oDB->Execute($sSql1);
                      }
                      if ($sACT == 'mstatus') {
                        $sSql1 = "UPDATE tbl_customer SET  member= '" . $sMemberStatus . "', user_update = '" . $sUserID . "'  WHERE id='" . $sID . "'";
                        $oDB->Execute($sSql1);
                      }

                      $axSql = $oDB->Query("SELECT * FROM tbl_inventory_adjustment_items WHERE order_id = '" . $sID . "'  ORDER BY id DESC");
                      $rownum = 1;
                      while ($asResult = $axSql->FetchRow(DBI_ASSOC)) {

                        $asResult["product_id"] = $oDB->QueryOne("SELECT brand_name FROM tbl_product WHERE id='" . $asResult["product_id"] . "' ");
                      ?>
                          <td><?php echo $rownum; ?></td>
                          <td><?php echo $asResult["product_id"]; ?></td>
                          <td><?php echo $asResult["quantity"]; ?></td>
                          <td><?php echo $asResult["price_per_unit"]; ?></td>
                          <td><?php echo $asResult["total_price"]; ?></td>
                          <td>
                            <?php if ($asResult["approve_status"] == 'A') { ?>
                              <a href="?act=inactive&status=N&id=<?php echo $sID; ?>&eid=<?php echo $asResult["id"]; ?>"><span class="badge badge-pill badge-success"><i class="fas fa-check-circle">
                                  </i>
                                  Active
                                </span>
                              </a>
                            <?php } else { ?>
                              <a href="?act=inactive&status=A&id=<?php echo $sID; ?>&eid=<?php echo $asResult["id"]; ?>"><span class="badge badge-pill badge-danger"><i class="far fa-times-circle">
                                  </i>
                                  InActive
                                </span>
                              </a>
                            <?php } ?>
                          </td>
                          <?php $rownum = $rownum + 1; ?>
                        </tr>
                        <?php } ?>
                        </tbody>
                    <tfoot>
                      <tr>
                        <th>No</th>
                        <th>ชื่อยา</th>
                        <th>จำนวน</th>
                        <th>ราคาต่อหน่วย</th>
                        <th>ราคารวม</th>
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
        "lengthChange": true,
        "autoWidth": false,
        "pageLength": 25,
        "buttons": ["csv", "excel", "pdf", "print", "colvis"],
        // "dom": '<"row"<"col-md-6 d-flex justify-content-start align-items-center" B l><"col-md-6 d-flex justify-content-end" f>>tip'
        "dom": '<"row"<"col-md-6 d-flex justify-content-start align-items-center"<"order-s1" B><"order-s2" l>><"col-md-6 d-flex justify-content-end" f>>tip'
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
  </script>
  
</body>
</html>
