$(document).ready(function() {
    var updateTotalDebounced = debounce(updateTotalOnServer, 500);

    $('.btn-up, .btn-down').on('click', function() {
        var cartItem = $(this).closest('.cart-items');
        var cart_id = cartItem.data('cart-id');
        var price = cartItem.data('price');
        var quantityInput = cartItem.find('input[name="quantity"]');
        var quantity = parseInt(quantityInput.val());
        var nameProduct = cartItem.find('.text-muted').html();

        var cartElement = $('.order-col[data-cart-id="' + cart_id + '"]');
        var priceEachItem = cartElement.find('.price-each-item');
        var totalMoneyOfProduct = cartElement.find('.price-product');
        priceEachItem.text(quantity + ' ' + nameProduct);
        totalMoneyOfProduct.text((price * quantity).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }));


        updateTotal(quantity, price, cartItem);
        updateTotalPrice();
        updateTotalDebounced(cart_id, quantity);
    });

    $('.input-quantity').on('change', function() {
        var cartItem = $(this).closest('.cart-items');
        var cart_id = cartItem.data('cart-id');
        var price = cartItem.data('price');
        var quantityInput = cartItem.find('input[name="quantity"]');
        var quantity = parseInt(quantityInput.val());
        var nameProduct = cartItem.find('.text-muted').html();

        var cartElement = $('.order-col[data-cart-id="' + cart_id + '"]');
        var priceEachItem = cartElement.find('.price-each-item');
        var totalMoneyOfProduct = cartElement.find('.price-product');
        priceEachItem.text(quantity + ' ' + nameProduct);
        totalMoneyOfProduct.text((price * quantity).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }));

        updateTotal(quantity, price, cartItem);
        updateTotalPrice();
        updateTotalDebounced(cart_id, quantity);
    });

    function updateTotalPrice() {
        var totalPrice = 0;
        $('.price-product').each(function() {
            console.log(this);
            var priceString = $(this).text().replace('đ', '').replace(/[.,]/g, '').trim();
            
            var price = parseFloat(priceString);
            totalPrice += price;
        });
        $('.order-total').text(totalPrice.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }));
    }    

    function debounce(callback, delay) {
        var timer;
        return function() {
            var context = this;
            var args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function() {
                callback.apply(context, args);
            }, delay);
        };
    }
    
    function updateTotal(quantity, price, cartItem) {
        var totalAmount = quantity * price;
        cartItem.find('.total-amount').text(totalAmount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }));

    }
    
    function updateTotalOnServer(cart_id, quantity) {
        $.ajax({
            url: 'http://localhost/shop/carts/updateQuantity',
            type: 'POST',
            data: {
                cart_id: cart_id,
                quantity: quantity 
            },
            success: function(response) {
                // Do nothing here since we have already updated the total amount display
            },
            error: function(xhr, status, error) {
                console.error("Error: " + status + ", " + error);
            }
        });
    }

    $('.dlt-product-in-the-cart').on('click',function(){
        alert('bạn có chắc muốn xoá')
    })

});
