<section class="h-100 h-custom" style="margin: 30px ">
  <div class="container-fluid py-5 h-100">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
        <div class="panel panel-default">
          <div class="panel-heading" style="background: #D10024;">
            <h1 class="panel-title fw-bold mb-0" style="color: white;">Shopping Cart</h1>
          </div>
          <div class="panel-body">
            <?php
              foreach ($dataCart as $cartItem) {
                echo '<div class="row cart-items" data-cart-id="'.$cartItem['id'].'" data-price="'.$cartItem['price'].'">';
                echo '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">';
                echo '<img src="'.$cartItem['image'].'" class="img-responsive rounded-3" alt="">';
                echo '</div>';
                echo '<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">';
                echo '<h5 class="text-muted">'.$cartItem['name'].'</h5>';
                echo '</div>';
                echo '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">';
                echo '<div class="input-group">';
                echo '<span class="input-group-btn">';
                echo '<button id="btn-up" class="btn btn-default btn-up" type="button" onclick="this.parentNode.parentNode.querySelector(\'input[type=number]\').stepDown()"><i class="fas fa-minus"></i></button>';
                echo '</span>';
                echo '<input id="form1" min="1" name="quantity" value="'.$cartItem['quantity'].'" type="number" class="form-control text-center input-quantity">';
                echo '<span class="input-group-btn">';
                echo '<button id="btn-down" class="btn btn-default btn-down" type="button" onclick="this.parentNode.parentNode.querySelector(\'input[type=number]\').stepUp()"><i class="fas fa-plus"></i></button>';
                echo '</span>';
                echo '</div>';
                echo '</div>';
                echo '<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">';
                echo '<h5 class="mb-0 total-amount">'.number_format($cartItem['price'] * $cartItem['quantity'], 0, ',', '.') . ' đ</h5>';
                echo '</div>';
                echo '<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 text-right">';
                echo '<a class="dlt-product-in-the-cart" href="http://localhost/webmobile/carts/deleteProductInTheCartById?cart_id='.$cartItem['id'].'" style="font-size: 25px"><i class="fas fa-times"></i></a>';
                echo '</div>';
                echo '</div>';
                echo '<hr class="my-4">';
              }
            ?>
            <div class="pt-5">
              <h5 class="mb-0"><a href="#!" class="text-body"><i class="fas fa-long-arrow-alt-left me-2"></i>Back to shop</a></h5>
            </div>
          </div>
        </div>
      </div>
      <!-- Order Details -->
      <div class="order-details col-lg-4">
        <div class="section-title text-center">
          <h3 class="title">Your Order</h3>
        </div>
        <div class="order-summary">
          <div class="order-col">
            <div><strong>PRODUCT</strong></div>
            <div><strong>TOTAL</strong></div>
          </div>
          <div class="order-products">
              <?php
              foreach ($dataCart as $cartItem) {
                echo '<div class="order-col" data-cart-id="' . $cartItem['id'] . '">';
                echo '<div class="price-each-item">' . $cartItem['quantity'] . 'x ' . $cartItem['name'] . '</div>';
                echo '<div class="price-product">' . number_format($cartItem['price'] * $cartItem['quantity'], 0, ',', '.') . ' đ</div>'; // Sử dụng hàm number_format để định dạng số thành tiền
                echo '</div>';
            }
              ?>
          </div>
          <div class="order-col">
            <div>Shiping</div>
            <div><strong>FREE</strong></div>
          </div>
          <div class="order-col">
            <div><strong>TOTAL</strong></div>
            <div><strong class="order-total">
              <?php
              $total = 0;
              foreach ($dataCart as $cartItem) {
                $total +=$cartItem['price'] * $cartItem['quantity'];
              }
              echo number_format($total , 0, ',', '.') . 'đ';
              ?>  
            </strong></div>
          </div>
        </div>
        <div class="payment-method">
          <div class="input-radio">
            <input type="radio" name="payment" id="payment-1">
            <label for="payment-1">
              <span></span>
              Direct Bank Transfer
            </label>
            <div class="caption">
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
          </div>
          <div class="input-radio">
            <input type="radio" name="payment" id="payment-2">
            <label for="payment-2">
              <span></span>
              Cheque Payment
            </label>
            <div class="caption">
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
          </div>
          <div class="input-radio">
            <input type="radio" name="payment" id="payment-3">
            <label for="payment-3">
              <span></span>
              Paypal System
            </label>
            <div class="caption">
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
          </div>
        </div>
        <div class="input-checkbox">
          <input type="checkbox" id="terms">
          <label for="terms">
            <span></span>
            I've read and accept the <a href="#">terms & conditions</a>
          </label>
        </div>
        <a href="http://localhost/webmobile/carts/placeOrder" class="primary-btn order-submit">Place order</a>
      </div>
      <!-- /Order Details -->
    </div>
  </div>
</section>
