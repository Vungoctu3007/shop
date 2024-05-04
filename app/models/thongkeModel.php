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
    //bieu do
    public function getMonthlyRevenue()
    {
        $sql = "SELECT MONTH(date_buy) as month, SUM(total) as totalRevenue
            FROM orders
            GROUP BY MONTH(date_buy)
            ORDER BY MONTH(date_buy)";
        $result = $this->__conn->query($sql);
        $data = array_fill(0, 12, 0); // Fill the array with 0s for months without data

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[$row['month'] - 1] = $row['totalRevenue']; // Subtract 1 because array index starts at 0
            }
        } else {
            error_log("SQL Error: " . $this->__conn->error);
        }
        return $data;
    }

    // biểu đồ tròn
    public function getSalesByCategory() {
        $sql = "SELECT c.category_name, COUNT(*) AS total_sales
                FROM orders o
                JOIN detail_order do ON o.order_id = do.order_id
                JOIN product_seri ps ON do.product_seri = ps.product_seri
                JOIN product p ON ps.product_id = p.product_id
                JOIN categories c ON p.category_id = c.category_id
                GROUP BY c.category_name";
    
        $result = $this->__conn->query($sql);
        $salesByCategory = [];
    
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $salesByCategory[] = array(
                    'category' => $row['category_name'],
                    'sales' => $row['total_sales']
                );
            }
        } else {
            error_log("SQL Error: " . $this->__conn->error);
        }
        return $salesByCategory;
    }
    
}
