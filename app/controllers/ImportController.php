<?php
class ImportController extends Controller
{
    public $data = [];
    public function __construct()
    {
    }

    public function index()
    {
        // $pageSize=isset($_GET['pageSize']) ? $_GET['pageSize'] :5;
        // $page=isset($_GET['page']) ? $_GET['page'] : 1;
        // $good_receipt = $this->model('ImportModel');
        // $dataa = $good_receipt->getAllGoodReceipt($page,$pageSize);
      
        $this->data['content'] = 'blocks/admin/Import/index';
        $this->data['sub_content']['data'] = [];
        $this->render('layouts/admin_layout', $this->data);
        // require_once("app/views/blocks/admin/Import/index.php");
    }
    public function getAll()
    {
        $pageSize = isset($_GET['pageSize']) ? $_GET['pageSize'] : 5;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $good_receipt = $this->model('ImportModel');
        $data = $good_receipt->getAllGoodReceipt($page, $pageSize);
        $total_data = $good_receipt->totalCount();
        $total_page = $total_data / $pageSize;
        if ($data) {
            header('Content-Type: application/json');
            echo json_encode(array(
                "total_page" => $total_page,
                $page,
                "data" => $data
            ));
        } else {
            echo "Error";
        }
    }
    public function add_supplier(){
        $good_receipt = $this->model('ImportModel');
        // $name_supplier,$phone_supplier,$address_supplier,$email_supplier
        $name_supplier = $_POST["name_supplier"];
        $phone_supplier = $_POST["phone_supplier"];
        $address_supplier = $_POST["address_supplier"];
        $email_supplier = $_POST["email_supplier"];
        $data=$good_receipt->add_supplier($name_supplier,$phone_supplier,$address_supplier,$email_supplier);
        if ($data) {
            header('Content-Type: application/json');
            echo json_encode(array(
                "data" => $data,
                "message"=>"thêm nhà cung cấp thành công"
            ), JSON_UNESCAPED_UNICODE); 
        } else {
            echo json_encode(array(
                "message"=>"thêm nhà cung cấp thất bại"
            ), JSON_UNESCAPED_UNICODE); 
        }
    }
    public function add_category(){
        $good_receipt = $this->model('ImportModel');
        $category_name = $_POST["name_category"];
        $data=$good_receipt->add_category($category_name);
        
        if ($data) {
            header('Content-Type: application/json');
            echo json_encode(array(
                "data" => $data,
                "message"=>"thêm loại sản phẩm thành công"
            ), JSON_UNESCAPED_UNICODE); 
        } else {
            echo json_encode(array(
                "message"=>"thêm loại sản phẩm thất bại"
            ), JSON_UNESCAPED_UNICODE); 
        }
    }
    // public function addNewProduct($category_id, $name, $date_insurance, $ram, $rom, $battery, $screen, $made_in, $year_produce, $image)
    public function addNewProduct(){
        $category_id = $_POST["category_id"];
        $product_name = $_POST["product_name"];
        $date_insurance = $_POST["date_insurance"];
        $ram = $_POST["ram"];
        $rom = $_POST["rom"];
        $battery = $_POST["battery"];
        $screen = $_POST["screen"];
        $made_in = $_POST["made_in"];
        $year_produce = $_POST["year_produce"];
        $img = $_POST["img"];
        $good_receipt = $this->model('ImportModel');
        $product_id = $good_receipt->addNewProduct($category_id, $product_name, $date_insurance , $ram, $rom, $battery , $screen, $made_in,$year_produce,$img);
        if ($product_id) {
            echo json_encode(array(
                "data" => $product_id,
                "message"=>"thêm sản phẩm thành công"
            ), JSON_UNESCAPED_UNICODE); 
        } else {
            echo json_encode(array(
                "message"=>"thêm sản phẩm thất bại"
            ), JSON_UNESCAPED_UNICODE); 
        }
    }
    public function getAllSupplier(){
        $good_receipt = $this->model('ImportModel');
        $data = $good_receipt->getAllSupplier();
        if ($data) {
            header('Content-Type: application/json');
            echo json_encode(array(
                "data" => $data
            ));
        } else {
            echo "Error";
        }
    }
    public function getAllCategory(){
        $good_receipt = $this->model('ImportModel');
        $data = $good_receipt->getAllCategories();
        if ($data) {
            header('Content-Type: application/json');
            echo json_encode(array(
                "data" => $data,
                "message"=>"thành công"
            ));
        } else {
            echo "Error";
        }
    }
    public function searchGoodReceipt()
    {
        $keyword = $_POST['searchInput'];
        $good_receipt = $this->model('ImportModel');
        $data = $good_receipt->searchGoodReceipt($keyword);
        if ($data) {
            header('Content-Type: application/json');
            echo json_encode(array(
                "data" => $data
            ));
        } else {
            echo "not found!";
        }
    }
    public function searchGoodReceiptByDate()
    {
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $good_receipt = $this->model('ImportModel');
        $data = $good_receipt->searchGoodReceiptByDate($startDate, $endDate);
        if ($data) {
            header('Content-Type: application/json');
            echo json_encode(array(
                "data" => $data
            ));
        } else {
            echo "not found!";
        }
    }
    
    public function ImportGoodReceipt()
    {
        $good_receipt = $this->model('ImportModel');
        $dataSupplier = $good_receipt->getAllSupplier();
        $dataCategory = $good_receipt->getAllCategories();
        $this->data['content'] = 'blocks/admin/Import/ImportGoodReceipt';
        $this->data['sub_content']['dataSupplier'] = $dataSupplier;
        $this->data['sub_content']['dataCategory'] = $dataCategory;
        $this->render('layouts/admin_layout', $this->data);
    }
    public function getAllProducts()
    {
        $keyword = $_POST['searchInput'];
        $good_receipt = $this->model('ImportModel');
        $data = $good_receipt->getAllProducts($keyword);
        if ($data) {
            header('Content-Type: application/json');
            echo json_encode(array(
                "data" => $data
            ));
        } else {
            echo "Error";
        }
    }
    public function getAllGoodReceptDetail()
    {   
        $good_receipt = $this->model('ImportModel');
        $data = $good_receipt->getAllGoodReceptDetail();
        if ($data) {
            header('Content-Type: application/json');
            echo json_encode(array(
                "data" => $data
            ));
        } else {
            echo "Error";
        }
    }
    //  detail good_receipt
    public function getAllDetailGoodById()
    {
        $id=$_POST["id"];
        $good_receipt = $this->model('ImportModel');
        $data = $good_receipt->getAllDetailGoodById($id);
        $data_good = $good_receipt->getGoodReceipt($id);
        if ($data) {
            header('Content-Type: application/json');
            echo json_encode(array(
                "data" => $data,
                "data_good"=>$data_good
            ));
        } else {
            echo "Error";
        }
    }
    public function insertGoodReceipt()
    {
        $good_receipt = $this->model('ImportModel');
        $supplier_id = $_POST["supplier_id"];
        $employee_id = $_POST["employee_id"];
        $date_good_receipt = $_POST["date_good_receipt"];
        $total = $_POST["total"];
        $product_details = $_POST["product_details"];
        echo var_dump($product_details);
        $good_receipt_id = $good_receipt->insertGoodReceipt($supplier_id, $employee_id, $date_good_receipt, $total, $product_details);
        if ($good_receipt_id) {
            echo "Đã thêm phiếu nhập hàng mới có ID: " . $good_receipt_id;
        } else {
            echo "Có lỗi xảy ra trong quá trình thêm phiếu nhập hàng.";
        }
    }
}
