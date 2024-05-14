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
    public function updateProduct($product_id, $product_name, $product_description, $product_ram, $product_rom, $product_battery, $product_screen, $product_made_in, $product_year_produce, $product_time_insurance, $product_price, $product_image)
    {
        $sql = "UPDATE product SET 
        product_image = ?,
        product_name = ?,
        product_description = ?,
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
        $stmt->bind_param("sssiiidsiiii", $product_image, $product_name, $product_description, $product_ram, $product_rom, $product_battery, $product_screen, $product_made_in, $product_year_produce, $product_time_insurance, $product_price, $product_id);

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
                    WHERE product_seri.product_id = product.product_id and product_seri.status = 1
                )";

        $result = $this->conn->query($sql);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function softProducIncreasing($column, $page, $pageSize)
    {
        $page = (int) $page;
        $pageSize = (int) $pageSize;

        // Calculate the starting row
        $start = ($page - 1) * $pageSize;
        if ($start < 0) {
            $start = 0;
        }
        $sql = "SELECT * FROM product INNER JOIN categories ON product.category_id = categories.category_id ORDER BY $column ASC LIMIT $start, $pageSize";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }


    public function softProducDescreasing($column, $page, $pageSize)
    {
        $page = (int) $page;
        $pageSize = (int) $pageSize;

        // Calculate the starting row
        $start = ($page - 1) * $pageSize;
        if ($start < 0) {
            $start = 0;
        }
        $sql = "SELECT * FROM product INNER JOIN categories ON product.category_id = categories.category_id ORDER BY $column DESC LIMIT $start, $pageSize";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }
    public function searchProduct($keyword, $page)
    {
        $page = (int) $page;
        $pageSize = (int) 4;

        // Calculate the starting row
        $start = ($page - 1) * $pageSize;
        if ($start < 0) {
            $start = 0;
        }

        $sql = "SELECT * FROM product 
            INNER JOIN categories ON product.category_id = categories.category_id 
            WHERE product.product_name LIKE '%$keyword%' or categories.category_name LIKE '%$keyword%' or product.product_made_in LIKE '%$keyword%' or product.product_year_produce LIKE '%$keyword%'
            LIMIT $start, $pageSize";

        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false;
        }
    }
    public function countProductBySearch($keyword)
    {
        $sql = "SELECT COUNT(*) as total_count FROM product 
            INNER JOIN categories ON product.category_id = categories.category_id 
            WHERE product.product_name LIKE N'%$keyword%' 
            OR categories.category_name LIKE N'%$keyword%' 
            OR product.product_made_in LIKE N'%$keyword%' 
            OR product.product_year_produce LIKE N'%$keyword%'
            OR product.product_ram LIKE N'%$keyword%'
            OR product.product_rom LIKE N'%$keyword%'
            OR product.quantity LIKE N'%$keyword%'
            OR product.product_battery LIKE N'%$keyword%'
            OR product.product_price LIKE N'%$keyword%'
            ";

        $result = $this->conn->query($sql);

        $row = $result->fetch_assoc();
        return $row['total_count'];
    }

    public function deleteProduct($product_id)
    {
        // Kiểm tra xem có tồn tại product_seri trong insurance hoặc detail_order không
        $check_sql = "SELECT COUNT(*) AS count
                  FROM product_seri s
                  LEFT JOIN insurance i ON s.product_seri = i.product_seri
                  LEFT JOIN detail_order d ON s.product_seri = d.product_seri
                  WHERE s.product_id = ?";

        $stmt_check = $this->conn->prepare($check_sql);
        $stmt_check->bind_param("i", $product_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        $row = $result_check->fetch_assoc();

        // Nếu có sản phẩm_seri tương ứng trong insurance hoặc detail_order, không thể xóa
        if ($row['count'] > 0) {
            return false;
        }

        // Xóa product_seri có status = 1 trước khi xóa product
        $delete_seri_sql = "UPDATE product_seri SET WHERE product_id = ? AND status = 1";

        $stmt_delete_seri = $this->conn->prepare($delete_seri_sql);
        $stmt_delete_seri->bind_param("i", $product_id);
        $stmt_delete_seri->execute();

        // Thực hiện xóa sản phẩm
        $sql = "DELETE FROM product WHERE product_id = ?";

        $stmt_delete = $this->conn->prepare($sql);
        $stmt_delete->bind_param("i", $product_id);
        $stmt_delete->execute();

        // Kiểm tra số hàng bị ảnh hưởng
        if ($stmt_delete->affected_rows > 0) {
            return true; // Xóa thành công
        } else {
            return false; // Không có gì bị xóa
        }
    }




}