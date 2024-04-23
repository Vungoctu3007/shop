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

    public function getCustomerById($customer_id) {
        $sql = "SELECT * FROM customer WHERE customer_id = ?";
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('s', $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0) {
            $customer = $result->fetch_assoc();
            return $customer;
        }else {
            return false;
        }
    }

}


?>

