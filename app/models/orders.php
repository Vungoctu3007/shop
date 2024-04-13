<?php
class Orders {
    private $conn;

    public function __construct() {
        global $db_config;
        $this->conn = Connection::getInstance($db_config);
    }

    public function getAllOrders($user_id) {
        
    }

    public function placeOrder($user_id, $total_amount) {
        $status = 'chưa xử lý';

        $now = new DateTime();
        $created_at = $now->format('Y-m-d H:i:s');
        $updated_at = $now->format('Y-m-d H:i:s');
    
        $sql = 'INSERT INTO  orders (user_id, status, total_amount, created_at, updated_at) VALUES (?, ?, ?, ?, ?)';
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            echo "Prepare statement failed: " . $this->conn->error;
            return false;
        }

        $stmt->bind_param('isiss', $user_id, $status, $total_amount, $created_at, $updated_at);

        if ($stmt->execute()) {
            $orderId = $stmt->insert_id;
            $stmt->close(); 
            return $orderId;
        } else {
            echo "Execution failed: " . $stmt->error;
            $stmt->close();
            return false;
        }
    }
    

    public function placeOrderWithItems($user_id, $order_id, $cartItems) {
        foreach ($cartItems as $cartItem) {
            $sql = 'INSERT INTO  order_items (order_id, product_id, price, quantity) VALUES (?, ?, ?, ?)';
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('iiii', $orderId, $cartItem['product_id'], $cartItem['price'], $cartItem['quantity']);
    
            if (!$stmt->execute()) {
                echo "Lỗi khi thêm sản phẩm vào đơn hàng: " . $stmt->error;
                return false;
            }
        }
    
        return $orderId;
    }
    
}