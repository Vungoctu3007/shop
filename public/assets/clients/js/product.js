$(document).ready(function(){
    var currentPage = 1;
    var itemsPerPage = 9; 
    var debounceTimer;
    function fetchData(page) {
        $.ajax({
            url: 'http://localhost/shop/product/getAllProducts',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                displayProducts(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    $('.category-checkbox, #price-range-start, #price-range-end').on('change', function () {
        getFilteredData(); 
    });

    $('#name-search').on('keyup', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(getFilteredData, 300); // Adjust the delay time (in milliseconds) as needed
    });

    function getFilteredData() {
        var nameQuery = $('#name-search').val();
        var categories = [];
        $('.category-checkbox:checked').each(function() {
            categories.push($(this).val());
        });
        var priceRangeStart = $('#price-range-start').val();
        var priceRangeEnd = $('#price-range-end').val();
        console.log(nameQuery);
        console.log(categories);
        console.log(priceRangeStart);
        console.log(priceRangeEnd);
        $.ajax({
            url: 'http://localhost/shop/product/getFilteredProducts',
            type: 'GET',
            dataType: 'json',
            data: {
                name: nameQuery,
                categories: categories,
                priceRangeStart: priceRangeStart,
                priceRangeEnd: priceRangeEnd
            },
            success: function (response) {
                if(response) {
                    displayProducts(response);
                } else {
                    $('#show-product').html('');
                    $('#store-pagination').html('');
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function displayProducts(products) {
        var productLength = products.length;
        var startIndex = currentPage * itemsPerPage - itemsPerPage ;

        var endIndex = startIndex + itemsPerPage;

        const currentProducts = products.slice(startIndex, endIndex);
        $('#show-product').html(''); 

        currentProducts.forEach(function(product) {
            var productHtml = '<div class="col-md-4 col-xs-6">';
            productHtml += '<div class="product">';
            productHtml += '<div class="product-img">';
            productHtml += '<img src="' + product.imgSrc + '" alt="">';
            productHtml += '<div class="product-label">';
            productHtml += '<span class="sale">' + product.sale + '</span>';
            productHtml += '</div>';
            productHtml += '</div>';
            productHtml += '<div class="product-body">';
            productHtml += '<h3 class="product-name"><a href="#">' + product.name + '</a></h3>';
            productHtml += '<h4 class="product-price">' + product.price + ' <del class="product-old-price">' + product.oldPrice + '</del></h4>';
            productHtml += '<div class="product-rating">';
            productHtml += '</div>';
            productHtml += '</div>';
            productHtml += '<div class="add-to-cart">';
            productHtml += '<button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</button>';
            productHtml += '</div>';
            productHtml += '</div>';
            productHtml += '</div>';

            $('#show-product').append(productHtml);
        });

        displayPagination(productLength);
    }

    function displayPagination(productLength) {
        var totalPages = Math.ceil(productLength/itemsPerPage);
        var paginationHTML = '';
        for(var i = 1; i <= totalPages; i++) {
            if(i == currentPage) {
                paginationHTML += '<li class="active">' + i + '</li>';
            }
            else {
                paginationHTML += '<li>' + i + '</li>';
            }
        }
        $('#store-pagination').html(paginationHTML);
    }
    function updatePagination(newPage) {
        currentPage = newPage; 
        getFilteredData(currentPage);
    }

    $(document).on('click', '#store-pagination li', function() {
        var newPage = parseInt($(this).text());
        updatePagination(newPage); 
    });

    fetchData(currentPage);
});
