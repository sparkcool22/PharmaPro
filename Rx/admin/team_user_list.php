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
if ($sID != 0) {
  $asTeamTitle = $oDB->QueryOne("SELECT team_name FROM tbl_team WHERE id='" . $sID . "' ") . ' (' . $oDB->QueryOne("SELECT team_code FROM tbl_team WHERE id='" . $sID . "' ") . ') Team';
} else {
  $asTeamTitle = "Team Center";
}

if ($_POST['teamlist']) {
foreach ($_POST['teamlist'] as $sKey => $sVal) {
    // $t[$sKey] = $sVal;
    $UpdateTeam = "UPDATE tbl_user_login SET team_id= '" . $sID . "' WHERE id='" . $sVal . "'";
    $oDB->Execute($UpdateTeam);

}
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
  <!-- <link rel="stylesheet" href="/PharmaPro/alte/plugins/fontawesome-free/css/all.css"> -->
  <link rel="stylesheet" href="/PharmaPro/alte/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="/PharmaPro/alte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="/PharmaPro/alte/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
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
                  <h3 class="card-title">User In <?php echo $asTeamTitle; ?></h3>
                  <div class=" float-sm-right">
                    <!-- <a class="btn btn-block btn-success btn-sm" href="user_form.php?act=new"><i class="fas fa-plus-circle" style="margin-right: 5px;"></i> Add User In Team</a> -->
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-lg">
                      Add User In Team
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example_userlist" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Tools</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if ($sACT == 'inactive') {

                        $sSql1 = "UPDATE tbl_user_login SET  user_status= '" . $sStatus . "' WHERE id='" . $sID . "'";
                        $oDB->Execute($sSql1);
                      }

                      $axSql = $oDB->Query("SELECT * FROM tbl_user_login WHERE team_id = $sID ORDER BY user_status ASC");
                      $rownum = 1;
                      while ($asResult = $axSql->FetchRow(DBI_ASSOC)) {

                        $asResult["teamname"] = $oDB->QueryOne("SELECT team_name FROM tbl_team WHERE id='" . $asResult["team_id"] . "' ");
                        $asResult["teamid"] = '<a href="#" data-toggle="tooltip" data-placement="top" title="' . $asResult["teamname"] . '">' . $oDB->QueryOne("SELECT team_code FROM tbl_team WHERE id='" . $asResult["team_id"] . "' ") . '</a>';
                      ?>
                        <tr <?php if ($asResult["approve_status"] == 'N') { ?> style="font-style: italic;text-decoration: underline; color: darkgray;" ; <?php } ?>>
                          <td><?php echo $rownum; ?></td>
                          <td><?php echo $asResult["employee_id"]; ?></td>
                          <td><?php echo $asResult["firstname"] . " " . $asResult["lastname"]; ?></td>
                          <td><?php echo $asResult["email"]; ?></td>
                          <td class="project-actions text-right">
                            <a class="btn btn-info btn-xs" href="user_view.php?act=view&id=<?php echo $asResult["id"]; ?>">
                              <!-- <i class="fas fa-search"> -->
                              </i>
                              <!-- View -->
                            </a>
                          </td>
                          <?php $rownum = $rownum + 1; ?>
                        </tr>
                      <?php } ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>No</th>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Email</th>
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

      <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">

          <form id="demoform" action="#" method="post">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Add User In <?php echo $asTeamTitle; ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">

                <form id="demoform" action="#" method="post">
                  <div class="card card-default">
                    <!-- /.card-header -->
                    <div class="card-body">
                      <div class="row">
                        <div class="col-12">
                          <div class="form-group">
                            <select class="duallistbox" multiple="multiple" size="10" name="teamlist[]" id="teamlist[]"  >
                <?php 
                $axSql_team = $oDB->Query("SELECT * FROM tbl_user_login WHERE team_id !='.$sID.'");
                $rownum = 1;
                while ($asResult_team = $axSql_team->FetchRow(DBI_ASSOC)) { ?>
                              <option value="<?php echo $asResult_team['id'];?>"><?php 
                              if ($asResult_team['team_id']==0) {
                                echo $asResult_team['firstname'] . ' ' . $asResult_team['lastname'] . ' - TCT' ;  
                              }else{
                                echo $asResult_team['firstname'].' '. $asResult_team['lastname'].' - '. $oDB->QueryOne("SELECT team_code FROM tbl_team WHERE id='" . $asResult_team["team_id"] . "' ") ;  
                              }
                              ?></option>

                <?php } ?>
                            </select>
                          </div>
                          <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->
                    </div>
                  </div>
                </form>

              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </form>

        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

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
  <!-- Bootstrap4 Duallistbox -->
  <script src="/PharmaPro/alte/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
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

  <script>
    $(function() {
      //Bootstrap Duallistbox
      $('.duallistbox').bootstrapDualListbox()
    })
  </script>
</body>

</html>