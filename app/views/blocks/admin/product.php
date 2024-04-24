<div class="container">
    <h2>Product Table</h2>
    <table class="table table-striped text-center">
        <thead>
            <tr>
                <th>Image</th>
                <th><?php echo ucfirst('Category Name'); ?></th>
                <th>Product Name</th>
                <th>Stock</th>
                <th>Made In</th>
                <th>Year Produce</th>
                <th>Time Insurance(Month)</th>
                <th>Price</th>
                <th>Operations</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($dataProduct) {
                foreach ($dataProduct as $Product) {
                    echo "<tr>";
                    echo "<td><img src='../public/assets/clients/img/" . $Product['product_image'] . "' alt='Product Image' style='width:130px; height:auto'></td>";
                    echo "<td>" . ucfirst($Product['category_name']) . "</td>";
                    echo "<td>" . $Product['product_name'] . "</td>";
                    echo "<td>" . $Product['quantity'] . "</td>";
                    echo "<td>" . $Product['product_made_in'] . "</td>";
                    echo "<td>" . $Product['product_year_produce'] . "</td>";
                    echo "<td>" . $Product['product_time_insurance'] . "</td>";
                    echo "<td>" . $Product['product_price'] . "</td>";
                    echo "<td>";
                    echo "<button class='btn btn-primary me-1 mb-3 w-100 mt-3' data-bs-toggle='modal' data-bs-target='#detailProduct' onclick='openDetailModal(" . $Product['product_id'] . ")'>Detail</button>";
                    echo "<button class='btn btn-primary me-1 mb-3 w-100 mt-3' data-bs-toggle='modal' data-bs-target='#updateProduct' onclick='openUpdateModal(" . $Product['product_id'] . ")'>Update</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailProduct" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="productDetails" class="text-center"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateProduct" tabindex="-1" aria-labelledby="updateProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateProductModalLabel">Update Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="productUpdates" class="text-center"></div>
                <input type="hidden" id="productId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateProduct()">Update</button>
            </div>
        </div>
    </div>
</div>

<script>
    function openDetailModal(productId) {
        $.ajax({
            type: "GET",
            url: `http://localhost/shop/Product_Admin/detail?id=${productId}`,
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
</script>

<script>
    function openUpdateModal(productId) {
        $.ajax({
            type: "GET",
            url: `http://localhost/shop/Product_Admin/detail?id=${productId}`,
            success: function (data) {
                var html = `
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name:</label>
                        <input type="text" class="form-control" id="productName" value="${data.data.product_name}">
                    </div>
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Category Name:</label>
                        <input type="text" class="form-control" id="categoryName" value="${data.data.category_name}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="ram" class="form-label">RAM (Gb):</label>
                        <input type="text" class="form-control" id="ram" value="${data.data.product_ram}">
                    </div>
                    <div class="mb-3">
                        <label for="rom" class="form-label">ROM (Gb):</label>
                        <input type="text" class="form-control" id="rom" value="${data.data.product_rom}">
                    </div>
                    <div class="mb-3">
                        <label for="battery" class="form-label">Battery (Mh):</label>
                        <input type="text" class="form-control" id="battery" value="${data.data.product_battery}">
                    </div>
                    <div class="mb-3">
                        <label for="screen" class="form-label">Screen:</label>
                        <input type="text" class="form-control" id="screen" value="${data.data.product_screen}">
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Stock:</label>
                        <input type="number" class="form-control" id="quantity" value="${data.data.quantity}">
                    </div>
                    <div class="mb-3">
                        <label for="madeIn" class="form-label">Made In:</label>
                        <input type="text" class="form-control" id="madeIn" value="${data.data.product_made_in}">
                    </div>
                    <div class="mb-3">
                        <label for="yearProduce" class="form-label">Year Produce:</label>
                        <input type="number" class="form-control" id="yearProduce" value="${data.data.product_year_produce}">
                    </div>
                    <div class="mb-3">
                        <label for="timeInsurance" class="form-label">Time Insurance (months):</label>
                        <input type="number" class="form-control" id="timeInsurance" value="${data.data.product_time_insurance}">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price:</label>
                        <input type="text" class="form-control" id="price" value="${data.data.product_price}">
                    </div>
                `;
                $('#productUpdates').html(html);
                $('#productId').val(productId);
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        })
    }
</script>
<script>
    function updateProduct() {
        var productId = $('#productId').val();
        var productName = $('#productName').val();
        var productRam = $('#ram').val();
        var productRom = $('#rom').val();
        var productBattery = $('#battery').val();
        var productScreen = $('#screen').val();
        var quantity = $('#quantity').val();
        var madeIn = $('#madeIn').val();
        var yearProduce = $('#yearProduce').val();
        var timeInsurance = $('#timeInsurance').val();
        var price = $('#price').val();

        $.ajax({
            type: "POST",
            url: "http://localhost/shop/Product_Admin/update",
            data: {
                product_id: productId,
                product_name: productName,
                product_ram: productRam,
                product_rom: productRom,
                product_battery: productBattery,
                product_screen: productScreen,
                quantity: quantity,
                product_made_in: madeIn,
                product_year_produce: yearProduce,
                product_time_insurance: timeInsurance,
                product_price: price
            },
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
</script>