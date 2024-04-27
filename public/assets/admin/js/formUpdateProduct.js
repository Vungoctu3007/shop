function openUpdateModal(productId) {
    $.ajax({
        type: "GET",
        url: `http://localhost/shop/Product_Admin/updateProductId?product_id=${productId}`,
        success: function (data) {
            toastr.success('Nhập thông tin khách hàng thành công');
            var html = `
                <div class="mb-3">
                    <label for="productNameUpdate" class="form-label">Product Name:</label>
                    <input type="text" class="form-control" id="productNameUpdate" value="${data.data.product_name}">
                </div>
                <div class="mb-3">
                    <label for="categoryNameUpdate" class="form-label">Category Name:</label>
                    <input type="text" class="form-control" id="categoryNameUpdate" value="${data.data.category_name}" disabled>
                </div>
                <div class="mb-3">
                    <label for="ramUpdate" class="form-label">RAM (Gb):</label>
                    <input type="text" class="form-control" id="ramUpdate" value="${data.data.product_ram}"  required>
                </div>
                <div class="mb-3">
                    <label for="romUpdate" class="form-label">ROM (Gb):</label>
                    <input type="text" class="form-control" id="romUpdate" value="${data.data.product_rom}"  required>
                </div>
                <div class="mb-3">
                    <label for="batteryUpdate" class="form-label">Battery (Mh):</label>
                    <input type="text" class="form-control" id="batteryUpdate" value="${data.data.product_battery}"  required>
                </div>
                <div class="mb-3">
                    <label for="screeUpdate" class="form-label">Screen:</label>
                    <input type="text" class="form-control" id="screenUpdate" value="${data.data.product_screen}"  required>
                </div>
                <div class="mb-3">
                    <label for="madeInUpdate" class="form-label">Made In:</label>
                    <input type="text" class="form-control" id="madeInUpdate" value="${data.data.product_made_in}" required>
                </div>
                <div class="mb-3">
                    <label for="yearProduceUpdate" class="form-label">Year Produce:</label>
                    <input type="number" class="form-control" id="yearProduceUpdate" value="${data.data.product_year_produce}"  required>
                </div>
                <div class="mb-3">
                    <label for="timeInsuranceUpdate" class="form-label">Time Insurance (months):</label>
                    <input type="number" class="form-control" id="timeInsuranceUpdate" value="${data.data.product_time_insurance}"  required>
                </div>
                <div class="mb-3">
                    <label for="priceUpdate" class="form-label">Price:</label>
                    <input type="text" class="form-control" id="priceUpdate" value="${data.data.product_price}"  required>
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
