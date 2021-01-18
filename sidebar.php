<?php
$current_file_name = basename($_SERVER['PHP_SELF']);
?>
<!-- sidebar -->

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->

      <li class="nav-item <?php if($current_file_name == "index.php"){ echo 'active'; } ?>">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
      <li class="nav-item <?php if($current_file_name == "affiliate_add_data.php"){ echo 'active'; } ?>">
        <a class="nav-link" href="affiliate_add_data.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Products</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item <?php if($current_file_name == "login.php" || $current_file_name == "register.php" || $current_file_name == "forgot-password.php" || $current_file_name == "404.php" || $current_file_name == "blank.php"){ echo 'active'; } ?> ">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-folder"></i>
          <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Login Screens:</h6>
            <a class="collapse-item" href="login.php">Login</a>

          </div>
        </div>
      </li>

      <!-- Nav Item - Charts -->
      <li class="nav-item <?php if($current_file_name == "charts.php"){ echo 'active'; } ?> ">
        <a class="nav-link" href="charts.php">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li>

      <!-- Nav Item - card-demo  -->
      <li class="nav-item <?php if($current_file_name == "card_demo.php"){ echo 'active'; } ?> ">
        <a class="nav-link" href="card_demo.php?page=1  ">
          <i class="fas fa-fw fa-table"></i>
          <span>Product Cards</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
