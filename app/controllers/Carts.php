<?php
class Carts extends Controller {
    public $data = [], $model = [];

    public function __construct()
    {
        //construct
    }

    public function index()
    {
        $cart = $this->model("cart");
        $dataCart = $cart->getJoinDataCartAndProducts();
        $this->data['content'] = 'blocks/clients/cart';
        $this->data['sub_content']['dataCart'] = $dataCart;
        $this->render('layouts/client_layout', $this->data);
    }

    public function updateQuantity() {
        $cart = $this->model("cart");
        $cart_id = (isset($_POST['cart_id'])) ? $_POST['cart_id'] : 0;
        $quantity = (isset($_POST['quantity']))? $_POST['quantity'] : 0;
        $cart->updateQuantityOfProductInTheCartByCartId($cart_id, $quantity);
        $dataCart = $cart->getQuantityOfProductInTheCartByCartId($cart_id);
        echo json_encode($dataCart);
    }
    
    public function deleteProductInTheCartById() {
        $cart = $this->model("cart");
        $cart_id = $_GET['cart_id'];
        $result = $cart->deleteProductInTheCartById($cart_id);
        $response = new Response();
        $response->redirect('carts');
    }

    public function placeOrder() {
        $cart = $this->model("cart");
        $orders = $this->model("orders");

        $user_id = $_SESSION['user_session']['user']['id'];
        $total_amount = $cart->getTotalAmountByUserId($user_id);
        $order_id = $orders->placeOrder($user_id, $total_amount);
        $cart_items = $cart->getProductsInTheCartByUserId($user_id);
        $orders->placeOrderWithItems($user_id, $order_id, $cart_items);
        $cart->deleteAllProductsInTheCartByUserId($user_id);
        
        $response = new Response();
        $response->redirect('carts');
    }
}