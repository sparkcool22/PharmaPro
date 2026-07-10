  <!-- Main Sidebar Container Menu ทั้งหมด-->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index.php" class="brand-link">
      <img src="../../img/i_logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 1">
      <span class="brand-text font-weight-light">Inventory Control</span>
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
            <a href="#" class="d-block"><?php echo $dataUserinfo['firstname'] . " " . $dataUserinfo['lastname']; ?></a>
          </div>
        <?php } else { ?>
          <div class="image">
            <img src="<?php echo "../upload/user_images/img_not.gif"; ?>" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?php echo $dataUserinfo['firstname'] . " " . $dataUserinfo['lastname']; ?></a>
          </div>
        <?php } ?>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Main Menu
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../register_draft_list.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Equipment Draft</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../job_activity.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Job Activity</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../register_form.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Register Equipment Form</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="../equipment_list.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Equipment Data
                <!--<span class="right badge badge-danger">New</span>-->
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../sap_list.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                SAP
                <!--<span class="right badge badge-danger">New</span>-->
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Approve
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php if ($_SESSION["au_privilege"]["Approve_Register"]) { ?>
                <li class="nav-item">
                  <a href="../register_approve_list.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Approve Register</p>
                  </a>
                </li>
              <?php } ?>
            </ul>
          </li>

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
                <a href="../logs.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Logs List</p>
                </a>
              </li>
            </ul>
          </li> -->

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
                <a href="../admin/user_list.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../admin/authen_list.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User Authentication</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../admin/team_list.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Team List</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
            </ul>
          </li>

          <li class="nav-item">
            <a href="../logout.php" class="nav-link">
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