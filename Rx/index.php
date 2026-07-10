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
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="/PharmaPro/alte/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/PharmaPro/alte/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="/PharmaPro/public/customCSS/custom_css.css">

    <style>
    @import url('https://fonts.googleapis.com/css2?family=Prompt&display=swap');

    /* body {
        font-family: 'Prompt', sans-serif;
        padding-bottom: 100px;
    } */

    .noClick {
        pointer-events: none;
        filter: grayscale(100%);
    }

    img {
        border-radius: 5px;
        overflow: hidden;
    }

    .custom-title-text {
        font-size: 2rem !important;
        /* ปรับขนาดฟอนต์ตามที่ต้องการ */
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
        <?php include("l_head_content.php"); ?>

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">

                <div class="row " style="margin-left: 60px; margin-right: 60px;">

                    <?php  if (!isset($_SESSION['aupro_member_id'])) {   ?>

                    <div class="row" style="margin-left: auto; margin-right: auto;">
                        <div class="col-12">
                            <a class="card cardActionShadowC text-white mt-3 cardActionRegister" style="border:none;"
                                href="login.php">
                                <img src="../img/notLogin_green.jpg" class="card-img" alt="NotLogin">
                                <div class="card-img-overlay d-flex flex-column">
                                    <h1 class="mt-auto ms-3 fw-bold"
                                        style="filter: drop-shadow(5px 5px 5px rgba(0, 0, 0, 0.7));">
                                        โปรดเข้าสู่ระบบก่อนเริ่มใช้งาน</h1>
                                    <h5 class="ms-3 fw-bold"
                                        style="filter: drop-shadow(5px 5px 5px rgba(0, 0, 0, 0.7));">
                                        คลิกที่นี่เพื่อเข้าสู่ระบบ...</h5>
                                </div>
                            </a>
                        </div>
                    </div>

                    <?php }else{  ?>

                    <div class="col-sm-12 col-md-6 col-lg-4" style="padding-left: 10px; padding-right: 10px;">
                        <a class="card cardActionShadowC text-white cardActionIndex" href="order.php"
                            data-bs-toggle="modal" data-bs-target="#registerEquipment">
                            <img src="../img/registerEq.jpg" class="card-img" alt="RegistEquipment">
                            <div class="card-img-overlay d-flex flex-column">
                                <h3 class="card-title mt-auto ms-3 fw-bold custom-title-text">Sales Counter</h3>
                            </div>
                        </a>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-4" style="padding-left: 10px; padding-right: 10px;">
                        <a class="card cardActionShadowC text-white cardActionIndex " href="product_list.php">
                            <img src="../img/MoveBetweenFloor.jpg" class="card-img" alt="MoveBetweenFloor">
                            <div class="card-img-overlay d-flex flex-column">
                                <h3 class="card-title mt-auto ms-3 fw-bold custom-title-text">Inventory Management</h3>
                            </div>
                        </a>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-4" style="padding-left: 10px; padding-right: 10px;">
                        <a class="card cardActionShadowC text-white cardActionIndex " href="dashboard_sales.php">
                            <img src="../img/ReturnPartner.jpg" class="card-img" alt="ReturnPartner">
                            <div class="card-img-overlay d-flex flex-column">
                                <h3 class="card-title mt-auto ms-3 fw-bold custom-title-text">Sales Dashboard</h3>
                            </div>
                        </a>
                    </div>


                    <div class="col-sm-12 col-md-6 col-lg-4" style="padding-left: 10px; padding-right: 10px;">
                        <a class="card cardActionShadowC text-white cardActionIndex " href="supplier_list.php">
                            <img src="../img/IncomingEquipment.jpg" class="card-img" alt="IncomingEquipment">
                            <div class="card-img-overlay d-flex flex-column">
                                <h3 class="card-title mt-auto ms-3 fw-bold custom-title-text">Supplier Management</h3>
                            </div>
                        </a>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-4" style="padding-left: 10px; padding-right: 10px;">
                        <a class="card cardActionShadowC text-white cardActionIndex " href="customer_list.php">
                            <img src="../img/OutgoingEquipment.jpg" class="card-img" alt="OutgoingEquipment">
                            <div class="card-img-overlay d-flex flex-column">
                                <h3 class="card-title mt-auto ms-3 fw-bold custom-title-text">Customer Management</h3>
                            </div>
                        </a>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-4" style="padding-left: 10px; padding-right: 10px;">
                        <a class="card cardActionShadowC text-white cardActionIndex " href="iv_adjustment.php">
                            <img src="../img/WriteOff.jpg" class="card-img" alt="WriteOff">
                            <div class="card-img-overlay d-flex flex-column">
                                <h3 class="card-title mt-auto ms-3 fw-bold custom-title-text">Inventory Adjustment</h3>
                            </div>
                        </a>
                    </div>
                    <?php } ?>


                </div>

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

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
    <script src="/PharmaPro/alte/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/PharmaPro/alte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/PharmaPro/alte/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="/PharmaPro/alte/dist/js/demo.js"></script>
</body>

</html>