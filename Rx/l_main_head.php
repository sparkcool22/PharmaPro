<?php
$Nom_Exp = $oDB->QueryOne("SELECT nom_expire FROM tbl_setting WHERE  approve_status = 'A' ");
$NotiExpire = $oDB->QueryOne("SELECT count(*) FROM tbl_product WHERE expiration_date IS NOT NULL AND expiration_date <> '1970-01-01' AND expiration_date < DATE_ADD(CURDATE(), INTERVAL $sExpireDate MONTH) AND quantity_in_stock > 0 AND approve_status = 'A' ");
$NotiMinQuantity = $oDB->QueryOne("SELECT count(*) FROM tbl_product WHERE min_quantity >= quantity_in_stock AND quantity_in_stock > 0 AND approve_status = 'A' ");
$NotiTotal = $NotiExpire + $NotiMinQuantity;
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
.btn-lightblue {
    background-color: #67C2D0;
    color: white;
}

.btn-lightblue:hover {
    background-color: #17a2b8;
    /* เปลี่ยนสีเมื่อ hover */
    color: white;
}
</style>
<!-- Navbar Head หลัก-->
<nav class="main-header navbar navbar-expand-md navbar-light navbar-white navbarCustom cardActionShadowM">
    <div class="container-fluid">
        <a href="index.php" class="navbar-brand d-flex align-items-center">
            <!-- โลโก้ร้าน -->
            <img src="../img/logo_white.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                style="opacity: .8">

            <!-- ชื่อร้าน + ไอคอนหมุน -->
            <span class="brand-text font-weight-light d-flex align-items-center ml-2">
                รุ่งเรืองเภสัช
                <i class="fas fa-spinner fa-spin fa-fw mx-2" style="color:red; font-size:16px;"></i>
                วัดมะเกลือ
            </span>
        </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <?php if (!isset($_SESSION['aupro_member_id'])) { ?>
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button" style="pointer-events: none;"><i
                            class="fas fa-bars"></i></a>
                </li>
                <?php }else{ ?>
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <?php } ?>
                <li class="nav-item">
                    <a href="index.php" class="nav-link">Home</a>
                </li>
                <!-- <li class="nav-item">
            <a href="#" class="nav-link">Contact</a>
          </li> -->
                <!-- <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Dropdown</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="#" class="dropdown-item">Some action </a></li>
              <li><a href="#" class="dropdown-item">Some other action</a></li>

              <li class="dropdown-divider"></li>

              <li class="dropdown-submenu dropdown-hover">
                <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Hover for action</a>
                <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                  <li>
                    <a tabindex="-1" href="#" class="dropdown-item">level 2</a>
                  </li>

                  <li class="dropdown-submenu">
                    <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">level 2</a>
                    <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 shadow">
                      <li><a href="#" class="dropdown-item">3rd level</a></li>
                      <li><a href="#" class="dropdown-item">3rd level</a></li>
                    </ul>
                  </li>

                  <li><a href="#" class="dropdown-item">level 2</a></li>
                  <li><a href="#" class="dropdown-item">level 2</a></li>
                </ul>
              </li>
            </ul>
          </li> -->
            </ul>

            <!-- SEARCH FORM -->
            <!-- <form class="form-inline ml-0 ml-md-3">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </form> -->
        </div>

        <!-- Right navbar links -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <!-- Messages Dropdown Menu -->
            <!-- <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fas fa-comments"></i>
            <span class="badge badge-danger navbar-badge">3</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <div class="dropdown-divider"></div>
            <div class="dropdown-divider"></div>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
          </div>
        </li> -->
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-danger navbar-badge"><?php echo $NotiTotal ; ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header"><?php echo $NotiTotal ; ?> Notifications</span>

                    <div class="dropdown-divider"></div>
                    <a href="product_expiredate.php"
                        class="dropdown-item d-flex justify-content-between align-items-center">
                        <span>
                            <i class="fas fa-clock mr-2" style="color:red"></i> ยาใกล้หมดอายุ
                            <small>(<?php echo $sExpireDate; ?> เดือน)</small>
                        </span>
                        <span class="text-muted text-sm">
                            <strong style="margin-right: 6px;"><?php echo $NotiExpire; ?></strong>
                            <strong>รายการ</strong>
                        </span>
                    </a>

                    <div class="dropdown-divider"></div>
                    <a href="product_min_quantity.php"
                        class="dropdown-item d-flex justify-content-between align-items-center">
                        <span>
                            <i class="fa-solid fa-file-prescription mr-2" style="color:red"></i> ยาคงเหลือที่น้อยที่สุด
                        </span>
                        <span class="text-muted text-sm">
                            <strong style="margin-right: 6px;"><?php echo $NotiMinQuantity; ?></strong>
                            <strong>รายการ</strong>
                        </span>
                    </a>

                    <div class="dropdown-divider"></div>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <!-- <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
          </a>
        </li>
 -->
            <li class="nav-item">
                <?php if (!isset($_SESSION['aupro_member_id'])) {
              $showmenu = 'hidden';
              echo '<a type="button" class="btn btn-lightblue mx-1" href="login.php" aria-expanded="false"><i class="bi bi-key"></i> Login</a>';
        } else if ($_SESSION["aupro_privilege"]["Administrator"]) {
              $showmenu = '';
              echo '<a class="btn btn-lightblue mx-1" aria-expanded="false" href="logout.php"><i class="bi bi-box-arrow-left"></i> Logout</a>';
        } ?>
            </li>
        </ul>
    </div>
</nav>
<!-- /.navbar -->