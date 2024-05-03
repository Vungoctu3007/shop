<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ</title>
    <style>
        body, h1, h2, h3, h4, h5, h6, p, ul, li, a {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .app-header {
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            z-index: 1000;
        }
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.5rem 1rem;
        }
        .navbar-nav {
            list-style: none;
            display: flex;
            align-items: center;
        }
        .nav-item {
            margin-left: 1rem;
        }
        .nav-link {
            display: flex;
            align-items: center;
            position: relative;
            text-decoration: none;
            color: #333;
            font-size: 1rem;
        }
        .nav-link .ti {
            margin-right: 0.3rem;
            font-size: 1.2rem;
        }
        .nav-link .notification {
            position: absolute;
            top: -0.25rem;
            right: -0.5rem;
            width: 0.8rem;
            height: 0.8rem;
            border-radius: 50%;
        }
        .navbar-collapse {
            margin-left: auto;
        }
        .dropdown-menu {
            position: absolute;
            right: 0;
            background-color: #fff;
            border-radius: 0.25rem;
            border: 1px solid rgba(0,0,0,0.1);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            width: 200px;
        }
        .dropdown-menu .dropdown-item {
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            color: #333;
            text-decoration: none;
            transition: background-color 0.2s ease-in-out;
        }
        .dropdown-menu .dropdown-item:hover {
            background-color: #f8f8f8;
        }
        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }
        .btn-primary {
            background-color: #007bff;
            color: #fff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-outline-primary {
            background-color: transparent;
            color: #007bff;
            border: 1px solid #007bff;
        }
        .btn-outline-primary:hover {
            background-color: #007bff;
            color: #fff;
        }
        img.rounded-circle {
            border-radius: 50%;
        }
        .announcement {
            text-align: center;
    
            padding: 10px 0;
            font-size: 1.2rem;
            color: #333;
            width: 80%;
            white-space: nowrap;
            overflow: hidden;
        }
        .announcement h1 {
            display: inline-block;
            padding-left: 100%;
            animation: marquee 15s linear infinite;
        }
        @keyframes marquee {
            from { transform: translateX(100%); }
            to { transform: translateX(-100%); }
        }
    </style>
</head>
<body>

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
          <a href="https://adminmart.com/product/modernize-free-bootstrap-admin-dashboard/" target="_blank" class="btn btn-primary">Hướng dẫn</a>
          <li class="nav-item dropdown">
            <!-- Your profile image dropdown and other items -->
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- Main content here -->

</body>
</html>
