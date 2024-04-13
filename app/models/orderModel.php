<?php
class orderModel{
    private $__conn;

    function __construct() {
        global $db_config;
        // Sử dụng thông tin cấu hình cơ sở dữ liệu để kết nối
        $this->__conn = Connection::getInstance($db_config);
    }

    // load list hóa đơn
    public function getAllorder() {
        $sql = "SELECT * FROM `orders`"; 
        $result = $this->__conn->query($sql);
        $order = array();
    
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $order[] = $row;
            }
        } else {
            error_log("SQL Error: " . $this->__conn->error);  // Ghi log lỗi SQL
        }
        return $order;
    }

    //thêm hóa đơn
    public function addOrder($orderData) {
        $columns = implode(", ", array_keys($orderData));
        $values  = "'" . implode("', '", array_values($orderData)) . "'";
        
        $sql = "INSERT INTO `orders` ($columns) VALUES ($values)";
        
        if ($this->__conn->query($sql)) {
            return $this->__conn->insert_id;
        } else {
            error_log("SQL Error: " . $this->__conn->error);
            return false;
        }
    }

    //cập nhật hóa đơn
    public function updateOrder($orderId, $orderData) {
        $setValues = [];
        foreach ($orderData as $key => $value) {
            $setValues[] = "$key = '$value'";
        }
        $setValuesString = implode(", ", $setValues);
        
        $sql = "UPDATE `orders` SET $setValuesString WHERE order_id = $orderId";
        
        if ($this->__conn->query($sql)) {
            return $this->__conn->affected_rows;
        } else {
            error_log("SQL Error: " . $this->__conn->error);
            return false;
        }
    }

    // xóa hóa đơn 
    public function deleteOrder($orderId) {
        $sql = "DELETE FROM `orders` WHERE order_id = $orderId";
        
        if ($this->__conn->query($sql)) {
            return $this->__conn->affected_rows;
        } else {
            error_log("SQL Error: " . $this->__conn->error);
            return false;
        }
    }

}



?>

