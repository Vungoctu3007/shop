
    function openDetailModal(productId) {
        $.ajax({
            type: "GET",
            url: `http://localhost/shop/Product_Admin/detailProductId?product_id=${productId}`,
            success: function (data) {
                var html = `
                <img id="productImage" src="../public/assets/clients/img/${data.data.product_image}" alt="Product Image" style="max-width: 150px;">
                <h5 id="productName">Product Name: ${data.data.product_name}</h5>
                <p><strong>Category Name:</strong> <span id="categoryName">${data.data.category_name}</span></p>
                <p><strong>RAM:</strong> <span id="ram">${data.data.product_ram}</span></p>
                <p><strong>ROM:</strong> <span id="rom">${data.data.product_rom}</span></p>
                <p><strong>Battery:</strong> <span id="battery">${data.data.product_battery}</span></p>
                <p><strong>Screen:</strong> <span id="screen">${data.data.product_screen}</span></p>
                <p><strong>Quantity:</strong> <span id="quantity">${data.data.quantity}</span></p>
                <p><strong>Made In:</strong> <span id="madeIn">${data.data.product_made_in}</span></p>
                <p><strong>Year Produce:</strong> <span id="yearProduce">${data.data.product_year_produce}</span></p>
                <p><strong>Time Insurance:</strong> <span id="timeInsurance">${data.data.product_time_insurance}</span> months</p>
                <p><strong>Price:</strong> <span id="price">${data.data.product_price}</span></p>
            `;
                $('#productId').val(productId);
                $('#productDetails').html(html);
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

