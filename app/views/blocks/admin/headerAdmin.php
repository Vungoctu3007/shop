
<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item d-block d-xl-none">
          <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
            <i class="ti ti-menu-2"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-icon-hover" href="javascript:void(0)">
            <i class="ti ti-bell-ringing"></i>
            <div class="notification bg-primary rounded-circle"></div>
          </a>
        </li>
      </ul>
      <div class="announcement">
          <h1>Chúc admin một ngày tốt lành!</h1>
      </div>
      <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
          <!-- <a href="https://adminmart.com/product/modernize-free-bootstrap-admin-dashboard/" target="_blank" class="btn btn-primary">Hướng dẫn</a> -->
          <li class="nav-item dropdown">
          <?php echo $_SESSION['user_session']['user']['username'];?>
          </li>
          <input id="role_id" type="hidden" value="<?php echo $_SESSION['user_session']['user']['role_id'];?>">
        </ul>
      </div>
    </nav>
  </header>

