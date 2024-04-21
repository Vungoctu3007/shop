
<?php
$routes['default_controller'] = 'home';

// Route clients
$routes['trang-chu'] = 'home/index';
$routes['dang-nhap'] = 'signin/login';
$routes['san-pham'] = 'product/index';
$routes['bill'] =  'OrderController/index';

// Route admin
$routes['admin/dashboard'] = 'admin/index';