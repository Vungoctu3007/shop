<?php
class Product_Admin extends Controller
{
    public $data = [], $model = [];
    public function __construct()
    {

    }
    public function index()
    {
        $pageSize = isset($_GET['pageSize']) ? $_GET['pageSize'] : 5;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $products = $this->model("ProductAdminModel");
        $Products = $products->getAllProducts($page, $pageSize);
        $this->data['content'] = 'blocks/admin/product';
        $this->data['sub_content']['dataProduct'] = $Products;
        $this->render('layouts/admin_layout', $this->data);
    }
    public function loadData()
{
    $pageSize = isset($_GET['pageSize']) ? $_GET['pageSize'] : 4;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $products = $this->model("ProductAdminModel");
    $Products = $products->getAllProducts($page, $pageSize);
    header('Content-Type: application/json');
    echo json_encode($Products,$page);
}

    public function detailProductId()
    {
        $product_id = $_GET['product_id'];
        $productModel = $this->model("ProductAdminModel");
        $product = $productModel->getProductById($product_id);
        header('Content-Type: application/json');
        echo json_encode(array("data" => $product));
    }
    public function updateProductId()
    {
        $product_id = $_GET['product_id'];
        $productModel = $this->model("ProductAdminModel");
        $product = $productModel->getProductById($product_id);
        header('Content-Type: application/json');
        echo json_encode(array("data" => $product));
    }


    public function update()
    {
        $productId = $_GET['product_id'] ?? null;
        if ($productId != null) {
            // Lấy dữ liệu từ form gửi lên
            $product_name = $_POST['product_name'];
            $product_ram = $_POST['product_ram'];
            $product_rom = $_POST['product_rom'];
            $product_battery = $_POST['product_battery'];
            $product_screen = $_POST['product_screen'];
            $product_made_in = $_POST['product_made_in'];
            $product_year_produce = $_POST['product_year_produce'];
            $product_time_insurance = $_POST['product_time_insurance'];
            $product_price = $_POST['product_price'];

            // Tiến hành cập nhật sản phẩm
            $productModel = $this->model("ProductAdminModel");
            $result = $productModel->updateProduct($productId, $product_name, $product_ram, $product_rom, $product_battery, $product_screen, $product_made_in, $product_year_produce, $product_time_insurance, $product_price);
            $productModel->updateProductQuantity();

            // Kiểm tra kết quả và trả về JSON response
            if ($result) {
                echo json_encode(
                    array(
                        "status" => "success",
                        "message" => "Product updated successfully"
                    )
                );
            } else {
                echo json_encode(
                    array(
                        "status" => "error",
                        "message" => "Failed to update product"
                    )
                );
            }
        } else {
            echo json_encode(
                array(
                    "status" => "error",
                    "message" => "Product ID not provided"
                )
            );
        }
    }

}