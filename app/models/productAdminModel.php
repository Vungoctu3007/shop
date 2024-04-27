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
        // Convert $page and $pageSize to integers
        $page = (int) $page;
        $pageSize = (int) $pageSize;

        // Calculate the starting row
        $start = ($page - 1) * $pageSize;
        if ($start < 0) {
            $start = 0;
        }

        $sql = "SELECT COUNT(*) as total_records FROM product";
        $result = $this->conn->query($sql);
        $total_records = $result->fetch_assoc()['total_records'];
        $total_page = ceil($total_records / $pageSize);

        $sql = "SELECT * FROM product JOIN categories ON product.category_id = categories.category_id LIMIT $start, $pageSize";
        $result = $this->conn->query($sql);
        if ($result) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return array("data" => $data, "total_page" => $total_page);
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
    public function updateProduct($product_id, $product_name, $product_ram, $product_rom, $product_battery, $product_screen, $product_made_in, $product_year_produce, $product_time_insurance, $product_price)
    {
        $sql = "UPDATE product SET 
        product_name = ?,
        product_ram = ?, 
        product_rom = ?, 
        product_battery = ?, 
        product_screen = ?,
        product_made_in = ?, 
        product_year_produce = ?, 
        product_time_insurance = ?, 
        product_price = ? 
        WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("siiidsiiii", $product_name, $product_ram, $product_rom, $product_battery, $product_screen, $product_made_in, $product_year_produce, $product_time_insurance, $product_price, $product_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function updateProductQuantity()
    {
        $sql = "UPDATE product
                SET quantity = (
                    SELECT COUNT(*) 
                    FROM product_seri 
                    WHERE product_seri.product_id = product.product_id
                )";

        $result = $this->conn->query($sql);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }



}