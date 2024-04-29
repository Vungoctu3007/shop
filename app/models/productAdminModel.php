<?php
class ProductAdminModel
{
    private $conn;
    public function __construct()
    {
        global $db_config;
        $this->conn = Connection::getInstance($db_config);
    }

    public function getAllProducts($page, $pageSize)
    {
        $start = ($page - 1) * $pageSize;
        $sql = "SELECT * FROM product JOIN categories ON product.category_id = categories.category_id LIMIT $start, $pageSize";
        $result = $this->conn->query($sql);
        if ($result) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    public function getProductById($product_id)
    {
        $sql = "SELECT * FROM product JOIN categories ON product.category_id = categories.category_id WHERE product.product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return false;
    }
    public function updateProductById($product_id, $product_name, $product_ram, $product_rom, $product_battery, $product_screen, $quantity, $product_made_in, $product_year_produce, $product_time_insurance, $product_price)
    {
        $sql = "UPDATE product SET 
        product_name = ?,
        product_ram = ?, 
        product_rom = ?, 
        product_battery = ?, 
        product_screen = ?, 
        quantity = ?, 
        product_made_in = ?, 
        product_year_produce = ?, 
        product_time_insurance = ?, 
        product_price = ? 
        WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("siiidisiiii", $product_name, $product_ram, $product_rom, $product_battery, $product_screen, $quantity, $product_made_in, $product_year_produce, $product_time_insurance, $product_price, $product_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


}