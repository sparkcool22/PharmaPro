  <!-- Main Sidebar Container Menu ทั้งหมด-->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index.php" class="brand-link">
          <img src="../img/logo_white.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
              style="opacity: 1">
          <span class="brand-text font-weight-light">รุ่งเรืองเภสัช</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <?php if ($dataUserinfo['picture']) { ?>

              <div class="image">
                  <img src="<?php echo $dataUserinfo['pic_url']; ?>" class="img-circle elevation-2" alt="User Image">
              </div>
              <div class="info">
                  <a href="#" class="d-block"><?php echo $dataUserinfo['full_name']; ?></a>
              </div>
              <?php } else { ?>
              <div class="image">
                  <img src="<?php echo "../upload/user_images/img_not.gif"; ?>" class="img-circle elevation-2"
                      alt="User Image">
              </div>
              <div class="info">
                  <a href="#"
                      class="d-block"><?php echo $dataUserinfo['firstname'] . " " . $dataUserinfo['lastname']; ?></a>
              </div>
              <?php } ?>
          </div>

          <!-- SidebarSearch Form -->
          <div class="form-inline">
              <div class="input-group" data-widget="sidebar-search">
                  <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                      aria-label="Search">
                  <div class="input-group-append">
                      <button class="btn btn-sidebar">
                          <i class="fas fa-search fa-fw"></i>
                      </button>
                  </div>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                              Sales Management
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="order.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Sales Counter</p>
                              </a>
                          </li>
                      </ul>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="sale_list.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Sales List</p>
                              </a>
                          </li>
                      </ul>
                  </li>

                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                              Drug Information
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="product_list.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Drug Info List</p>
                              </a>
                          </li>
                      </ul>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="drug_category_list.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Drug Category</p>
                              </a>
                          </li>
                      </ul>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="drug_unit_category_list.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Drug Unit Category</p>
                              </a>
                          </li>
                      </ul>
                  </li>

                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                              Dashboard
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="dashboard_sales.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Sales Dashboard</p>
                              </a>
                          </li>
                      </ul>
                  </li>

                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                              Inventory Adjustment
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="iv_adjustment.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>IV Adjustment</p>
                              </a>
                          </li>
                      </ul>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="iv_adjustment_list.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>IV Adjustment List</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item">
                      <a href="supplier_list.php" class="nav-link">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                              Supplier
                              <!--<span class="right badge badge-danger">New</span>-->
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="customer_list.php" class="nav-link">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                              Customer
                              <!--<span class="right badge badge-danger">New</span>-->
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                              Authentication
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="staff_list.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Staff Management</p>
                              </a>
                          </li>
                      </ul>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="staff_authen.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Staff Authentication</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item">
                      <a href="p_setting.php?act=edit" class="nav-link">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                              Setting
                              <!--<span class="right badge badge-danger">New</span>-->
                          </p>
                      </a>
                  </li>
                  <?php if ($_SESSION["aupro_privilege"]["Approve_Register"]) { ?>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                              Approve
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="../formpage/register_approve_list.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Approve Register</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <?php } ?>
                  <!-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Log
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../formpage/logs.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Logs List</p>
                </a>
              </li>
            </ul>
          </li> -->
                  <?php if ($_SESSION["aupro_privilege"]["Approve_Register"]) { ?>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-users-cog"></i>
                          <p>
                              User Authentication
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="../formpage/admin/user_list.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>User List</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="../formpage/admin/authen_list.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>User Authentication</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="../formpage/admin/team_list.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Team List</p>
                              </a>
                          </li>
                      </ul>
                      <ul class="nav nav-treeview">
                      </ul>
                  </li>
                  <?php } ?>

                  <?php if ($_SESSION["aupro_privilege"]["Approve_Register"]) { ?>
                  <li class="nav-item">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                              Configuration
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="../formpage/location_list.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Rack Name Qrcode</p>
                              </a>
                          </li>
                      </ul>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="../formpage/location_list.php" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Location Setting</p>
                              </a>
                          </li>
                      </ul>
                      <ul class="nav nav-treeview">
                      </ul>
                  </li>
                  <?php } ?>

                  <li class="nav-item">
                      <a href="logout.php" class="nav-link">
                          <i class="nav-icon far fa-circle text-danger"></i>
                          <p>
                              LogOut
                              <!--<span class="right badge badge-danger">New</span>-->
                          </p>
                      </a>
                  </li>

              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>