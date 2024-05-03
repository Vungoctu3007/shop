<?php
class thongkeModel
{
    private $__conn;

    function __construct()
    {
        global $db_config;
        // Sử dụng thông tin cấu hình cơ sở dữ liệu để kết nối
        $this->__conn = Connection::getInstance($db_config);
    }

    // load list hóa đơn
    public function getthongke()
    {
        $sql = "SELECT 
                orders.order_id, 
                orders.customer_id,
                orders.employee_id, 
                orders.total, 
                orders.date_buy, 
                product.product_name, 
                product.quantity
            FROM orders
            JOIN detail_order ON orders.order_id = detail_order.order_id
            JOIN product_seri ON detail_order.product_seri = product_seri.product_seri
            JOIN product ON product_seri.product_id = product.product_id;";
        $result = $this->__conn->query($sql);
        $thongke = array();

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $thongke[] = $row;
            }
        } else {
            error_log("SQL Error: " . $this->__conn->error);  // Ghi log lỗi SQL
        }
        return $thongke;
    }
}
