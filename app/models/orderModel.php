<?php
class orderModel
{
    private $__conn;

    function __construct()
    {
        global $db_config;
        // Sử dụng thông tin cấu hình cơ sở dữ liệu để kết nối
        $this->__conn = Connection::getInstance($db_config);
    }

    // load list hóa đơn
    public function getAllorder()
    {
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



    //cập nhật hóa đơn
    public function updateOrder($orderId, $orderData)
    {
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

    // Phương thức xóa hóa đơn
    public function deleteOrder($orderId)
    {
        $sql = "DELETE FROM `orders` WHERE order_id = ?";
        $stmt = $this->__conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $orderId);
            if ($stmt->execute()) {
                return $stmt->affected_rows;
            } else {
                error_log("SQL Error: " . $this->__conn->error);
                return false;
            }
        } else {
            error_log("Prepare Statement Error: " . $this->__conn->error);
            return false;
        }
    }


    public function addOrder($orderData)
    {
        // Kiểm tra dữ liệu đầu vào ở đây...

        // Chuẩn bị câu lệnh SQL để chèn dữ liệu
        $stmt = $this->__conn->prepare("INSERT INTO orders (customer_id, employee_id, total, date_buy) VALUES (?, ?, ?, ?)");

        // Đối với NVARCHAR, sử dụng 's' thay vì 'i'
        $stmt->bind_param(
            "ssds",
            $orderData['customer_id'],
            $orderData['employee_id'],
            $orderData['total'],
            $orderData['date_buy']
        );

        // Thực hiện câu lệnh và kiểm tra kết quả
        if ($stmt->execute()) {
            $stmt->close();
            return $this->__conn->insert_id; // Trả về ID của hóa đơn vừa được thêm
        } else {
            error_log("SQL Error: " . $this->__conn->error);
            $stmt->close();
            return false;
        }
    }

    public function getOrderById($orderId) {
        $sql = "SELECT * FROM `orders` WHERE order_id = ?";
        $stmt = $this->__conn->prepare($sql);
        if ($stmt) {
         
            $stmt->bind_param("i", $orderId);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $order = $result->fetch_assoc();
                $stmt->close();
                return $order;
            } else {
                error_log("SQL Error: " . $this->__conn->error);
                $stmt->close();
                return false;
            }
        } else {
            error_log("Prepare Statement Error: " . $this->__conn->error);
            return false;
        }
    }

    public function updateOrderedit($orderId, $orderData) {
        // Câu lệnh SQL cập nhật dữ liệu hóa đơn với các tham số đã được bind
        $sql = "UPDATE `orders` SET customer_id = ?, employee_id = ?, total = ?, date_buy = ? WHERE order_id = ?";
        
        // Chuẩn bị câu lệnh
        $stmt = $this->__conn->prepare($sql);
        
        if ($stmt) {
            // Bind các giá trị vào câu lệnh SQL
            $stmt->bind_param("ssdsi",
                $orderData['customer_id'],
                $orderData['employee_id'],
                $orderData['total'],
                $orderData['date_buy'],
                $orderId
            );

            // Thực thi câu lệnh và kiểm tra kết quả
            if ($stmt->execute()) {
                $stmt->close();
                return true;
            } else {
                error_log("SQL Error: " . $this->__conn->error);
                $stmt->close();
                return false;
            }
        } else {
            error_log("Prepare Statement Error: " . $this->__conn->error);
            return false;
        }
    }


    //tìm kiếm
    public function getOrdersByEmployeeId($employee_id) {
        $sql = "SELECT * FROM orders WHERE employee_id = ?";
        $stmt = $this->__conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $employee_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $orders = [];
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
            $stmt->close();
            return $orders;
        } else {
            error_log("Prepare Statement Error: " . $this->__conn->error);
            return false;
        }
       
    }
    
}
