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

    public function getTotalRevenue()
    {
        $sql = "SELECT SUM(orders.total) AS totalRevenue
        FROM orders
        JOIN detail_order ON orders.order_id = detail_order.order_id";
        $result = $this->__conn->query($sql);
        return $result ? $result->fetch_assoc()['totalRevenue'] : 0;
    }

    public function getTotalProductsSold()
    {
        $sql = "SELECT SUM(product.quantity) AS totalProductsSold
        FROM orders
        JOIN detail_order ON orders.order_id = detail_order.order_id
        JOIN product_seri ON detail_order.product_seri = product_seri.product_seri
        JOIN product ON product_seri.product_id = product.product_id";
        $result = $this->__conn->query($sql);
        return $result ? $result->fetch_assoc()['totalProductsSold'] : 0;
    }

    public function getTotalSalesStaff()
    {
        $sql = "SELECT COUNT(DISTINCT employee_id) AS totalSalesStaff FROM orders";
        $result = $this->__conn->query($sql);
        return $result ? $result->fetch_assoc()['totalSalesStaff'] : 0;
    }

    public function getTotalCustomers()
    {
        $sql = "SELECT COUNT(DISTINCT customer_id) AS totalCustomers FROM orders";
        $result = $this->__conn->query($sql);
        return $result ? $result->fetch_assoc()['totalCustomers'] : 0;
    }

    //loc thong ke
    public function timthongke($start_date, $end_date)
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
        JOIN product ON product_seri.product_id = product.product_id
        WHERE orders.date_buy >= ? AND orders.date_buy <= ?";
    
    $stmt = $this->__conn->prepare($sql);
    $stmt->bind_param("ss", $start_date, $end_date);
    $stmt->execute();
    $result = $stmt->get_result();
    $thongke = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $thongke[] = $row;
        }
    } else {
        error_log("SQL Error: " . $this->__conn->error);  // Ghi log lỗi SQL
    }
    
    $stmt->close();
    return $thongke;
}
}
