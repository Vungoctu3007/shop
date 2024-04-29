
<?php
$routes['default_controller'] = 'home';

// Route clients
$routes['trang-chu'] = 'home/index';
$routes['dang-nhap'] = 'signin/login';
$routes['san-pham'] = 'product/index';
$routes['bill'] =  'OrderController/index';

// Route admin
$routes['admin/dashboard'] = 'admin/index';

$routes['admin/product'] = 'Product_Admin/index';
//phần hóa đơn

$routes['bill'] = 'OrderController/index';
$routes['xoa-hoa-don/([0-9]+)'] = 'OrderController/delete/$1';
$routes['them-hoa-don'] = 'OrderController/showAddForm';
$routes['xu-ly-them-hoa-don'] = 'OrderController/add'; 
$routes['sua-hoa-don/([0-9]+)'] = 'OrderController/edit/$1';
$routes['cap-nhat-hoa-don/([0-9]+)'] = 'OrderController/update/$1';
$routes['tim-kiem-theo-ma-nhan-vien'] = 'OrderController/searchByEmployee';
$routes['get-order-products/([0-9]+)'] = 'OrderController/getOrderProductDetails/$1';


//end hóa đơn 


//thống kê

$routes['thongke'] = 'ThongKeController/index';

