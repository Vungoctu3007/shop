<?php

class Cart
{
    private $__conn;

    function __construct(){
        global $db_config;
        $this->__conn = Connection::getInstance($db_config);
    }

    public function getNumOfProductInTheCartByUserId($userId) {
        $sql = "SELECT COUNT(*) AS num_rows FROM tbl_cart WHERE user_id = ?";

        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('s', $userId);
        $stmt->execute();

        $result = $stmt->get_result();
        $numOfProduct = 0;
        if($row = $result->fetch_assoc()) {
            $numOfProduct = $row['num_rows'];
            return $numOfProduct;
        } else {
            return false;
        }
    }

    public function getAllOrdersInTheCart() {
        $sql = "SELECT * FROM tbl_cart";
        $result = $this->__conn->query($sql);
        if($result) {
            $data = array();
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getProductsInTheCartByUserId($user_id) {
        $sql = "SELECT * FROM tbl_cart WHERE user_id =?";

        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('s', $user_id);
        $stmt->execute();

        $result = $stmt->get_result();
        if($result) {
            $data = array();
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
/**
 * 
 */
    public function deleteProductInTheCartById($cart_id) {
        $sql = 'DELETE FROM tbl_cart WHERE id = ?';
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('s', $cart_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result) {
            return true;
        }
        return false;
    }

    public function updateQuantityOfProductInTheCartByCartId($cart_id, $quantity) {
        $sql = 'UPDATE tbl_cart SET quantity = ? WHERE id = ?';
        $stmt = $this->__conn->prepare($sql);

        if ($stmt === false) {
            echo "Error preparing statement: " . $this->__conn->error;
            return false;
        }

        $stmt->bind_param('ii', $quantity, $cart_id); 

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getQuantityOfProductInTheCartByCartId($cart_id) {
        $sql = 'SELECT quantity FROM tbl_cart WHERE id =?';

        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('i', $cart_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $quantity = 0;
        if($row = $result->fetch_assoc()) {
            $quantity = $row['quantity'];
            return $quantity;
        } else {
            return false;
        }
    }

    public function getJoinDataCartAndProducts() {
        $sql = 'SELECT tbl_cart.quantity, tbl_cart.id, tbl_products.price, tbl_products.image, tbl_products.name
                FROM tbl_cart JOIN tbl_products ON tbl_cart.product_id = tbl_products.id
                WHERE tbl_cart.user_id = ?';

        $stmt = $this->__conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $this->__conn->error);
        }

        $user_id = isset($_SESSION['user_session']['user']['id']) ? $_SESSION['user_session']['user']['id'] : null;
        $stmt->bind_param('s', $user_id);

        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }
        $result = $stmt->get_result();
        if (!$result) {
            die("Get result failed: " . $stmt->error);
        }
        $cartItems = array();
        while ($row = $result->fetch_assoc()) {
            $cartItems[] = $row;
        }
        $stmt->close();
        
        return $cartItems;
    }
    
    public function deleteAllProductsInTheCartByUserId($user_id) {
        $sql = 'DELETE FROM tbl_cart WHERE user_id =?';
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('s', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result) {
            return true;
        }
        return false;
    }
    
    public function getTotalAmountByUserId($user_id) {
        $sql = 'SELECT SUM(tbl_cart.quantity * tbl_products.price) AS total_amount FROM tbl_cart JOIN tbl_products ON tbl_cart.product_id = tbl_products.id WHERE tbl_cart.user_id =?';
        $stmt = $this->__conn->prepare($sql);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $totalAmount = 0;
        if($row = $result->fetch_assoc()) {
            $totalAmount = $row['total_amount'];
            return $totalAmount;
        } else {
            return false;
        }
    }
    
}
