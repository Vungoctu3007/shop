<?php

class CustomerModel {
    protected $db;

    private $__conn;

    function __construct()
    {
        global $db_config;
        // Sử dụng thông tin cấu hình cơ sở dữ liệu để kết nối
        $this->__conn = Connection::getInstance($db_config);
    }

    public function getCustomers() {
        $sql = "SELECT customer_id, customer_name FROM customer";
        $result = $this->__conn->query($sql);
        $customers = [];
        while ($row = $result->fetch_assoc()) {
            $customers[] = $row;
        }
        return $customers;
    }
}


?>

