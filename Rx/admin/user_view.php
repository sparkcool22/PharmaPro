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
	$dataUserinfo = $oDB->QueryRow("SELECT * FROM tbl_user_login WHERE id='".$sUserID."'", DBI_ASSOC);
	$dataUserinfo['pic_url'] = USERIMG_URL.$dataUserinfo['picture'];
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
  <link rel="stylesheet" href="/PharmaPro/alte/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/PharmaPro/alte/dist/css/adminlte.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="/PharmaPro/alte/plugins/summernote/summernote-bs4.min.css">
  <!-- CodeMirror -->
  <link rel="stylesheet" href="/PharmaPro/alte/plugins/codemirror/codemirror.css">
  <link rel="stylesheet" href="/PharmaPro/alte/plugins/codemirror/theme/monokai.css">
  <!-- SimpleMDE -->
  <link rel="stylesheet" href="/PharmaPro/alte/plugins/simplemde/simplemde.min.css">

	
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <?php  include("../admin/l_head_m1.php");  ?> 

  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php  include("../admin/l_menu.php");  ?> 

<?php
if ($sACT=='view'){
  $asData = $oDB->QueryRow("SELECT * FROM tbl_user_login WHERE id='".$sID."' ", DBI_ASSOC);
}
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
		  
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">User Detail</h3>
              </div>
             </div>
            </div>
           </div>
		<!--First Half-->	
		 <div class="row">
			 <div class="col-md-8">
                <div class="card-body">
                <div class="callout callout-warning">
                  <h5>User Name</h5>
                  <p><?php echo base64_decode(isset($asData['user']) ? $asData['user'] : '') ;?></p>
                </div>
                <div class="row">
                  <div class="col-md-8">
                      <div class="callout callout-info">
                      <h5>Email</h5>
                      <p><?php echo isset($asData['email']) ? $asData['email'] : '';?></p>
                      </div>
                  </div>
                    <div class="col-md-4">
                        <div class="callout callout-info">
                        <h5>Employee ID</h5>
                        <p><?php echo isset($asData['employee_id']) ? $asData['employee_id'] : '';?></p>
                        </div>
                    </div>
                </div>
                <div class="callout callout-warning">
                  <h5>Name</h5>
                  <p><?php echo (isset($asData['firstname']) ? $asData['firstname'] : '') ." ". (isset($asData['lastname']) ? $asData['lastname'] : '') ;?></p>
                </div>
                <div class="row">
                  <div class="col-md-6">
                      <div class="callout callout-info">
                      <h5>Position</h5>
                      <p><?php echo isset($asData['position']) ? $asData['position'] : '';?></p>
                      </div>
                  </div>
                    <div class="col-md-6">
                        <div class="callout callout-info">
                        <h5>Department</h5>
                        <p><?php echo isset($asData['department']) ? $asData['department'] : '';?></p>
                        </div>
                    </div>
                </div>
                <div class="callout callout-warning">
                  <h5>Picture</h5>
                  <p><?php echo isset($asData['picture']) ? $asData['picture'] : '';?></p>
                </div>
					
                <div class="row">	
				        <div class="col-md-4">	
                <div class="callout callout-success">
                  <h5>User Level </h5>
                  <p>
                  <?php if (($asData["user_level"]=='A') || ($asData["user_level"]=='S')) {
										echo "Open" ;
									}else{
										echo "Lock";
									} 
                    ?>
                  </p>
                </div>
                </div>
                <div class="col-md-4">	
                <div class="callout callout-success">
                  <h5>User Status </h5>
                  <p>
                    <?php if ($asData["user_status"]=='A') {
										echo "Active" ;
									}else{
										echo "InActive";
									} 
                    ?>
                  </p>
                </div>
                </div>
                <div class="col-md-4">	
                <div class="callout callout-success">
                  <h5>Confirm Status </h5>
                  <p>
                  <?php if ($asData["confirm_status"]=='A') {
										echo "Active" ;
									}else{
										echo "InActive";
									} 
                    ?>
                  </p>
                </div>
                </div>
                </div>

		</div>  
		</div>  
			 
			<!--Second Half-->			
		<!--Second Half-->		
			 
    </div>
    </section>
  </div>
  <!-- /.content-wrapper -->

<?php  include("layout_footer.php");  ?> 

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
<!-- AdminLTE App -->
<script src="/PharmaPro/alte/dist/js/adminlte.min.js"></script>
<!-- Summernote -->
<script src="/PharmaPro/alte/plugins/summernote/summernote-bs4.min.js"></script>
<!-- CodeMirror -->
<script src="/PharmaPro/alte/plugins/codemirror/codemirror.js"></script>
<script src="/PharmaPro/alte/plugins/codemirror/mode/css/css.js"></script>
<script src="/PharmaPro/alte/plugins/codemirror/mode/xml/xml.js"></script>
<script src="/PharmaPro/alte/plugins/codemirror/mode/htmlmixed/htmlmixed.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/PharmaPro/alte/dist/js/demo.js"></script>
<script src="/PharmaPro/alte/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
	
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>

<script>
  $(function () {
    // Summernote
    $('#du_detail').summernote()
    $('#du_sub_detail').summernote()

    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
      mode: "htmlmixed",
      theme: "monokai"
    });
  })
</script>
</body>
</html>
