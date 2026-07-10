<?php
include("../../include/config.php");
include("../../include/common.php");

CheckUserLogin_Backend();

$sUserID = isset($_SESSION['au_member_id']) ? $_SESSION['au_member_id'] : '';
$sACT =  isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
$sStatus =  isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
$sID =  isset($_REQUEST['id']) ? $_REQUEST['id'] : '';

$oDB = new DBI();

if ($sUserID) {
  $dataUserinfo = $oDB->QueryRow("SELECT * FROM tbl_user_login WHERE id='" . $sUserID . "'", DBI_ASSOC);
  $dataUserinfo['pic_url'] = USERIMG_URL . $dataUserinfo['picture'];
}

$sTeam = $oDB->QueryOne("SELECT COUNT(*) FROM tbl_user_login WHERE team_id=0 ");
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
  <!-- <link rel="stylesheet" href="../l_head_m1.php"> -->
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <?php include("../admin/l_head_m1.php");  ?>
    <?php include("../admin/l_menu.php");  ?>
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Team List</h3>
                  <div class=" float-sm-right">
                    <a class="btn btn-block btn-success btn-sm" href="team_form.php?act=new"><i class="fas fa-plus-circle"></i> Create Team</a>
                  </div>
                  <div class=" float-sm-right" style="margin-right : 10px;">
                    <a class="btn btn-block btn-primary btn-sm" href="team_user_list.php?act=view&id=0"><i class="fas fa-plus-circle"></i> Team Center ( <?php echo $sTeam ?> )</a>
                  </div>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example_userlist" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Total Count</th>
                        <th>Team Code</th>
                        <th>Team Name</th>
                        <th>Status</th>
                        <th>Tools</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if ($sACT == 'inactive') {

                        $sSql1 = "UPDATE tbl_team SET  approve_status= '" . $sStatus . "' WHERE id='" . $sID . "'";
                        $oDB->Execute($sSql1);
                      }

                      $axSql = $oDB->Query("SELECT * FROM tbl_team  ORDER BY approve_status ASC, id ASC ");
                      $rownum = 1;
                      while ($asResult = $axSql->FetchRow(DBI_ASSOC)) {

                      ?>
                        <tr <?php if ($asResult["approve_status"] == 'N') { ?> style="font-style: italic;text-decoration: underline; color: darkgray;" ; <?php } ?>>
                          <td><?php echo $rownum; ?></td>
                          <td><?php echo $oDB->QueryOne("SELECT COUNT(*) FROM tbl_user_login WHERE team_id=" . $asResult["id"] . " "); ?></td>
                          <td><?php echo $asResult["team_code"]; ?></td>
                          <td><?php echo $asResult["team_name"] . " " . $asResult["lastname"]; ?></td>
                          <td>
                            <?php if ($asResult["approve_status"] == 'A') { ?>
                              <a href="?act=inactive&status=N&id=<?php echo $asResult["id"]; ?>"><span class="badge badge-pill badge-success"><i class="fas fa-check-circle">
                                  </i>
                                  Active
                                </span>
                              </a>
                            <?php } else { ?>
                              <a href="?act=inactive&status=A&id=<?php echo $asResult["id"]; ?>"><span class="badge badge-pill badge-danger"><i class="far fa-times-circle">
                                  </i>
                                  InActive
                                </span>
                              </a>
                            <?php } ?>
                          </td>
                          <td class="project-actions text-right">
                            <a class="btn btn-info btn-xs" href="team_user_list.php?act=view&id=<?php echo $asResult["id"]; ?>">
                              <i class="fas fa-search">
                              </i>
                              View
                            </a>
                          </td>
                          <?php $rownum = $rownum + 1; ?>
                        </tr>
                      <?php } ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>No</th>
                        <th>Total Count</th>
                        <th>Team Code</th>
                        <th>Team Name</th>
                        <th>Status</th>
                        <th>Tools</th>
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
  <script>
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example_grouplist').DataTable({
        "paging": true,
        "pageLength": 30,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
      $('#example_userlist').DataTable({
        "paging": true,
        "pageLength": 30,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>
</body>

</html>