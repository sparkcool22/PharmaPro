    <!-- Right navbar links -->
    <?php if (isset($_SESSION['aupro_member_id'])) { ?>

<div class="content-wrapper ">
  <!-- Content Header (Page header) -->
  <div class="content-header ">
    <div class="container-fluid">
      <div class="row mb-2" style="margin-left: 60px; margin-right: 60px;">
        <div class="col-sm-6">
          <h5 class="m-0"> ยินดีต้อนรับ<?php echo " คุณ " . $dataUserinfo['full_name']; ?></h5>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Layout</a></li>
            <li class="breadcrumb-item active">Top Navigation</li>
            <li class="breadcrumb-item active"> -->
            <img src="<?php echo $dataUserinfo['pic_url']; ?>" class="img-circle elevation-2" alt="User Image" style="width: 30px; height: 30px;">
            
            </li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
<?php } ?>
