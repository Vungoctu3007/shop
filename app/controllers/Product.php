<?php
class Product extends Controller {
    public $data = [], $model = [];

    public function __construct() {

    }

    public function index($urlProduct='') {
        if($urlProduct == '') {
            $categories = $this->model("categories");
            $dataCategories = $categories->getAllCategories();
            $this->data['content'] = 'blocks/clients/product';
            $this->data['sub_content']['dataCategories'] = $dataCategories;
            $this->render('layouts/client_layout', $this->data);
        } else {
            $product = $this->model("products");
            $dataProduct = $product->getProductByUrl($urlProduct);
            $this->data['content'] = 'blocks/clients/product-detail';
            $this->data['sub_content']['dataProduct'] = $dataProduct;
            $this->render('layouts/client_layout', $this->data);
        }
    }

    public function getAllProducts() {
        $products = $this->model("products");
        $dataProducts = $products->getAllProducts();
        echo json_encode($dataProducts);
    }

    public function getFilteredProducts() {
        $product = $this->model("products");
        $categories = isset($_GET['categories']) ? $_GET['categories'] : [];
        $dataProduct = $product->getProductsByCategoryAndFilters($categories, $_GET['name'], $_GET['priceRangeStart'], $_GET['priceRangeEnd']);
        echo json_encode($dataProduct);
    }

}