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
    public function getthongke($offset, $limit)
    {
        $sql = "SELECT
                orders.order_id, 
                orders.account_id, 
                orders.status_order_id, 
                orders.employee_id, 
                orders.total, 
                orders.date_buy, 
                product.product_name, 
                product.quantity
            FROM orders
            JOIN detail_order ON orders.order_id = detail_order.order_id
            JOIN product_seri ON detail_order.product_seri = product_seri.product_seri
            JOIN product ON product_seri.product_id = product.product_id
            JOIN status_order ON orders.status_order_id = status_order.status_order_id
            WHERE orders.status_order_id = 2
            LIMIT ?, ?";




        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param("ii", $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $thongke = [];

        // Lưu kết quả vào mảng
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $thongke[] = $row;
            }
        } else {
            error_log("SQL Error: " . $this->__conn->error);  // Ghi log lỗi SQL
        }

        // Đóng statement
        $stmt->close();
        return $thongke;
    }


    public function getTotalRevenue()
    {
        $sql = "SELECT SUM(orders.total) AS totalRevenue
                FROM orders
                JOIN detail_order ON orders.order_id = detail_order.order_id
                WHERE orders.status_order_id = 2";
        $result = $this->__conn->query($sql);
        return $result ? $result->fetch_assoc()['totalRevenue'] : 0;
    }


    public function getTotalProductsSold()
    {
        $sql = "SELECT SUM(product.quantity) AS totalProductsSold
                FROM orders
                JOIN detail_order ON orders.order_id = detail_order.order_id
                JOIN product_seri ON detail_order.product_seri = product_seri.product_seri
                JOIN product ON product_seri.product_id = product.product_id
                WHERE orders.status_order_id = 2";
        $result = $this->__conn->query($sql);
        return $result ? $result->fetch_assoc()['totalProductsSold'] : 0;
    }

    public function getTotalSalesStaff()
    {
        $sql = "SELECT COUNT(DISTINCT employee_id) AS totalSalesStaff
                FROM orders
                WHERE orders.status_order_id = 2";
        $result = $this->__conn->query($sql);
        return $result ? $result->fetch_assoc()['totalSalesStaff'] : 0;
    }


    public function getTotalAccounts()
    {
        $sql = "SELECT COUNT(DISTINCT account_id) AS totalAccounts
            FROM orders
            WHERE orders.status_order_id = 2";
        $result = $this->__conn->query($sql);
        return $result ? $result->fetch_assoc()['totalAccounts'] : 0;
    }

    //loc thong ke
    public function timthongke($start_date, $end_date, $offset, $limit)
    {
        $sql = "SELECT 
                orders.order_id, 
                orders.account_id, 
                orders.status_order_id, 
                orders.employee_id, 
                orders.total, 
                orders.date_buy, 
                product.product_name, 
                product.quantity
            FROM orders
            JOIN detail_order ON orders.order_id = detail_order.order_id
            JOIN product_seri ON detail_order.product_seri = product_seri.product_seri
            JOIN product ON product_seri.product_id = product.product_id
            WHERE orders.date_buy >= ? AND orders.date_buy <= ? 
            AND orders.status_order_id = 2
            LIMIT ?, ?";

        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param("ssii", $start_date, $end_date, $offset, $limit);
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
        $sql = "SELECT MONTH(date_buy) AS month, SUM(total) AS totalRevenue
                FROM orders
                WHERE orders.status_order_id = 2
                GROUP BY MONTH(date_buy)
                ORDER BY MONTH(date_buy)";
        $result = $this->__conn->query($sql);
        $data = array_fill(0, 12, 0); // Tạo mảng với 12 tháng ban đầu

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[$row['month'] - 1] = $row['totalRevenue']; // Chỉ số mảng bắt đầu từ 0
            }
        } else {
            error_log("SQL Error: " . $this->__conn->error);
        }
        return $data;
    }


    // biểu đồ tròn
    public function getSalesByCategory()
    {
        $sql = "SELECT c.category_name, COUNT(*) AS total_sales
                FROM orders o
                JOIN detail_order do ON o.order_id = do.order_id
                JOIN product_seri ps ON do.product_seri = ps.product_seri
                JOIN product p ON ps.product_id = p.product_id
                JOIN categories c ON p.category_id = c.category_id
                WHERE o.status_order_id = 2
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


    // Hàm đếm tổng số bản ghi
    public function countThongkeRecords()
    {
        $sql = "SELECT COUNT(*) AS totalRecords FROM orders";
        $result = $this->__conn->query($sql);
        return $result ? $result->fetch_assoc()['totalRecords'] : 0;
    }



    // Lấy thống kê tăng dần, có phân trang
    public function getThongKeAscPaginated($offset, $limit)
    {
        $sql = "SELECT 
        orders.order_id, 
        orders.account_id, 
        orders.status_order_id, 
        orders.employee_id, 
        orders.total, 
        orders.date_buy, 
        product.product_name, 
        product.quantity
    FROM orders
    JOIN detail_order ON orders.order_id = detail_order.order_id
    JOIN product_seri ON detail_order.product_seri = product_seri.product_seri
    JOIN product ON product_seri.product_id = product.product_id
    WHERE orders.status_order_id = 2
    ORDER BY orders.total ASC
    LIMIT ?, ?";

        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param("ii", $offset, $limit);
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



    // Lấy thống kê giảm dần, có phân trang
    public function getThongKeDescPaginated($offset, $limit)
    {
        $sql = "SELECT 
            orders.order_id, 
            orders.account_id, 
            orders.status_order_id, 
            orders.employee_id, 
            orders.total, 
            orders.date_buy, 
            product.product_name, 
            product.quantity
        FROM orders
        JOIN detail_order ON orders.order_id = detail_order.order_id
        JOIN product_seri ON detail_order.product_seri = product_seri.product_seri
        JOIN product ON product_seri.product_id = product.product_id
        WHERE orders.status_order_id = 2
        ORDER BY orders.total DESC
        LIMIT ?, ?";


        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param("ii", $offset, $limit);
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

    // Trong Model (thongkeModel)
    public function getAvailableYears()
    {
        $sql = "SELECT DISTINCT YEAR(date_buy) AS year
            FROM orders
            ORDER BY year";
        $result = $this->__conn->query($sql);
        $years = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $years[] = $row['year'];
            }
        }

        return $years;
    }

    // Trong Model (thongkeModel)
    public function getMonthlyRevenueByYear($year)
    {
        $sql = "SELECT MONTH(date_buy) as month, SUM(total) as totalRevenue
            FROM orders
            WHERE YEAR(date_buy) = ?
            GROUP BY MONTH(date_buy)
            ORDER BY MONTH(date_buy)";
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param("i", $year);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = array_fill(0, 12, 0); // Đặt mặc định tất cả các tháng đều là 0

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[$row['month'] - 1] = $row['totalRevenue'];
            }
        }

        return $data;
    }
}
