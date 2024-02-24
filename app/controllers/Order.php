<?php
class Order extends Controller {
    public $data = [], $model = [];

    public function __construct() {

    }

    public function index() {
        $orders = $this->model("orders");

        if(isset($_SESSION['user_session']['user']['id'])) {
            $user_id = $_SESSION['user_session']['user']['id'];
            $dataOrders = $orders->getAllOrders($user_id);
            $this->data['content'] = 'blocks/clients/orders';
            $this->data['sub_content']['dataOrders'] = $dataOrders;
            $this->render('layouts/client_layout', $this->data);
        }
    }
}